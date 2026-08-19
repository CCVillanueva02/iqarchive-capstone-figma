<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureAuditTrails();
        $this->configureAuthorization();
    }

    /**
     * Configure event listeners to automatically generate audit logs.
     */
    protected function configureAuditTrails(): void
    {
        // 1. Successful Authentication Logins
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Login::class,
            function (\Illuminate\Auth\Events\Login $event) {
                \App\Models\AuditLog::create([
                    'user_id' => $event->user->id,
                    'action' => 'login',
                    'target_type' => \App\Models\User::class,
                    'target_id' => $event->user->id,
                    'timestamp' => now(),
                ]);
            }
        );

        // 2. Authentication Logouts
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Logout::class,
            function (\Illuminate\Auth\Events\Logout $event) {
                if ($event->user) {
                    \App\Models\AuditLog::create([
                        'user_id' => $event->user->id,
                        'action' => 'logout',
                        'target_type' => \App\Models\User::class,
                        'target_id' => $event->user->id,
                        'timestamp' => now(),
                    ]);
                }
            }
        );

        // 3. Password Resets
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\PasswordReset::class,
            function (\Illuminate\Auth\Events\PasswordReset $event) {
                \App\Models\AuditLog::create([
                    'user_id' => $event->user->id,
                    'action' => 'password_reset',
                    'target_type' => \App\Models\User::class,
                    'target_id' => $event->user->id,
                    'timestamp' => now(),
                ]);
            }
        );

        // 4. Document Eloquent Observers
        \App\Models\Document::created(function (\App\Models\Document $document) {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? $document->uploaded_by,
                'action' => 'document_upload',
                'target_type' => \App\Models\Document::class,
                'target_id' => $document->id,
                'timestamp' => now(),
            ]);
        });

        \App\Models\Document::updated(function (\App\Models\Document $document) {
            $action = 'document_update';

            if ($document->isDirty('status')) {
                $status = $document->status;
                if ($status === 'approved') {
                    $action = 'document_approve';
                } elseif ($status === 'rejected') {
                    $action = 'document_reject';
                }
            }

            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? $document->confirmed_by ?? $document->uploaded_by,
                'action' => $action,
                'target_type' => \App\Models\Document::class,
                'target_id' => $document->id,
                'timestamp' => now(),
            ]);
        });

        \App\Models\Document::deleted(function (\App\Models\Document $document) {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? $document->uploaded_by,
                'action' => 'document_delete',
                'target_type' => \App\Models\Document::class,
                'target_id' => $document->id,
                'timestamp' => now(),
            ]);
        });
    }

    /**
     * Configure Gates and Policies for role-based authorization.
     */
    protected function configureAuthorization(): void
    {
        // Only IQA Staff (and System Administrator) can manage (add/remove) Task Force members
        Gate::define('manageTaskForceMembers', function (\App\Models\User $user) {
            return $user->hasRole(['iqa-staff', 'system-administrator']);
        });

        // Deans, IQA Staff, University Admins, System Admins, and assigned members can view Task Force roster
        Gate::define('viewTaskForceRoster', function (\App\Models\User $user, \App\Models\TaskForce $taskForce) {
            if ($user->hasRole(['iqa-staff', 'system-administrator', 'university-administrator'])) {
                return true;
            }
            if ($user->hasRole('college-head') && $user->college_id === $taskForce->college_id) {
                return true;
            }
            return $taskForce->members()->where('users.id', $user->id)->exists();
        });

        // TaskForce Created Observer: Automatically assign college Dean as Task Force Lead
        \App\Models\TaskForce::created(function (\App\Models\TaskForce $taskForce) {
            if ($taskForce->college_id) {
                $collegeHeadRoleId = \App\Models\Role::where('role_name', 'college-head')->value('id');
                if ($collegeHeadRoleId) {
                    $deans = \App\Models\User::where('college_id', $taskForce->college_id)
                        ->where(function ($query) use ($collegeHeadRoleId) {
                            $query->where('role_id', $collegeHeadRoleId)
                                ->orWhereHas('roles', function ($q) use ($collegeHeadRoleId) {
                                    $q->where('roles.id', $collegeHeadRoleId);
                                });
                        })->get();

                    foreach ($deans as $dean) {
                        \App\Models\TaskForceMember::firstOrCreate(
                            ['task_force_id' => $taskForce->id, 'user_id' => $dean->id],
                            ['role_in_team' => 'lead', 'assigned_at' => now()]
                        );
                    }
                }
            }
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
