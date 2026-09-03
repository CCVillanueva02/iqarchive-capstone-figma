<?php

namespace App\Providers;

use App\Models\AuditLog;
use App\Models\Document;
use App\Models\Role;
use App\Models\TaskForce;
use App\Models\TaskForceMember;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
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
        Event::listen(
            Login::class,
            function (Login $event) {
                AuditLog::create([
                    'user_id' => $event->user->id,
                    'action' => 'login',
                    'target_type' => User::class,
                    'target_id' => $event->user->id,
                    'timestamp' => now(),
                ]);
            }
        );

        // 2. Authentication Logouts
        Event::listen(
            Logout::class,
            function (Logout $event) {
                if ($event->user) {
                    AuditLog::create([
                        'user_id' => $event->user->id,
                        'action' => 'logout',
                        'target_type' => User::class,
                        'target_id' => $event->user->id,
                        'timestamp' => now(),
                    ]);
                }
            }
        );

        // 3. Password Resets
        Event::listen(
            PasswordReset::class,
            function (PasswordReset $event) {
                AuditLog::create([
                    'user_id' => $event->user->id,
                    'action' => 'password_reset',
                    'target_type' => User::class,
                    'target_id' => $event->user->id,
                    'timestamp' => now(),
                ]);
            }
        );

        // 4. Document Eloquent Observers
        Document::created(function (Document $document) {
            AuditLog::create([
                'user_id' => auth()->id() ?? $document->uploaded_by,
                'action' => 'document_upload',
                'target_type' => Document::class,
                'target_id' => $document->id,
                'timestamp' => now(),
            ]);
        });

        Document::updated(function (Document $document) {
            $action = 'document_update';

            if ($document->isDirty('status')) {
                $status = $document->status;
                if ($status === 'approved') {
                    $action = 'document_approve';
                } elseif ($status === 'rejected') {
                    $action = 'document_reject';
                }
            }

            AuditLog::create([
                'user_id' => auth()->id() ?? $document->confirmed_by ?? $document->uploaded_by,
                'action' => $action,
                'target_type' => Document::class,
                'target_id' => $document->id,
                'timestamp' => now(),
            ]);
        });

        Document::deleted(function (Document $document) {
            AuditLog::create([
                'user_id' => auth()->id() ?? $document->uploaded_by,
                'action' => 'document_delete',
                'target_type' => Document::class,
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
        // Only IQA Staff (and System Administrator) can manage (add/edit/soft-delete) Colleges & Programs
        Gate::define('manageCollegesAndPrograms', function (User $user) {
            return $user->hasRole(['iqa-staff', 'system-administrator']);
        });

        // Authorized roles can view Colleges & Programs configuration
        Gate::define('viewCollegesAndPrograms', function (User $user) {
            return $user->hasRole(['iqa-staff', 'system-administrator', 'university-administrator', 'college-head', 'task-force-member']);
        });

        // Only IQA Staff (and System Administrator) can manage (add/remove) Task Force members
        Gate::define('manageTaskForceMembers', function (User $user) {
            return $user->hasRole(['iqa-staff', 'system-administrator']);
        });

        // Deans, IQA Staff, University Admins, System Admins, and assigned members can view Task Force roster
        Gate::define('viewTaskForceRoster', function (User $user, TaskForce $taskForce) {
            if ($user->hasRole(['iqa-staff', 'system-administrator', 'university-administrator'])) {
                return true;
            }
            if ($user->hasRole('college-head') && $user->college_id === $taskForce->college_id) {
                return true;
            }

            return $taskForce->members()->where('users.id', $user->id)->exists();
        });

        // TaskForce Created Observer: Automatically assign college Dean as Task Force Lead
        TaskForce::created(function (TaskForce $taskForce) {
            if ($taskForce->college_id) {
                $collegeHeadRoleId = Role::where('role_name', 'college-head')->value('id');
                if ($collegeHeadRoleId) {
                    $deans = User::where('college_id', $taskForce->college_id)
                        ->where(function ($query) use ($collegeHeadRoleId) {
                            $query->where('role_id', $collegeHeadRoleId)
                                ->orWhereHas('roles', function ($q) use ($collegeHeadRoleId) {
                                    $q->where('roles.id', $collegeHeadRoleId);
                                });
                        })->get();

                    foreach ($deans as $dean) {
                        TaskForceMember::firstOrCreate(
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
