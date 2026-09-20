<?php

/**
 * ============================================================================
 * IQArchive v2 — Developer Sandbox Authentication Controller
 * ============================================================================
 * File: app/Http/Controllers/DevAuthController.php
 * Responsibility: Provides instant role switching and test user provisioning
 *                 exclusively in local and testing development environments.
 * Architecture: Controller Layer (Local Testing Gateway)
 * Security Context: STRICTLY restricted to local/testing environments.
 *                   Must abort 404 in production to prevent unauthorized access.
 * ============================================================================
 */

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\College;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DevAuthController extends Controller
{
    /**
     * Display the Developer Sandbox Role Switcher console.
     *
     * Security Reasoning: Local sandbox only. In production, returns 404 to hide route existence.
     */
    public function index(): Response
    {
        if (! app()->environment(['local', 'testing'])) {
            abort(404);
        }

        return Inertia::render('Auth/DevLogin', [
            'roles' => $this->getAvailableRoles(),
        ]);
    }

    /**
     * Instantly authenticate as a pre-configured role test user.
     *
     * Security Reasoning: Strictly blocked outside of local/testing environments.
     * Provisions required roles and colleges automatically so developer workflows never stall.
     */
    public function login(string $role, Request $request): RedirectResponse
    {
        if (! app()->environment(['local', 'testing'])) {
            abort(404);
        }

        $config = $this->resolveRoleConfiguration($role);

        // Ensure default college exists for college-scoped roles
        $collegeId = null;
        if ($config['requires_college']) {
            $college = College::firstOrCreate(
                ['code' => 'CS'],
                ['name' => 'College of Science']
            );
            $collegeId = $college->id;
        }

        // Find or provision the sandbox user
        $user = User::withoutGlobalScopes()->where('email', $config['email'])->first();

        if (! $user) {
            $user = User::create([
                'name' => $config['name'],
                'email' => $config['email'],
                'college_id' => $collegeId,
                'status' => 'active',
                'google_id' => 'dev_' . md5($config['email']),
                'avatar_url' => null,
            ]);
        } else {
            $user->update([
                'status' => 'active',
                'college_id' => $collegeId ?? $user->college_id,
            ]);
        }

        // Sync role assignments
        $roleModels = [];
        foreach ($config['roles'] as $roleName => $displayName) {
            $roleRecord = Role::firstOrCreate(
                ['name' => $roleName],
                [
                    'display_name' => $displayName,
                    'description' => "Institutional role: {$displayName}",
                ]
            );
            $roleModels[] = $roleRecord->id;
        }

        $user->roles()->sync($roleModels);

        // Authenticate and regenerate session
        Auth::login($user);
        $request->session()->regenerate();

        // Audit Logging
        AuditLog::withoutGlobalScopes()->create([
            'college_id' => $user->college_id,
            'user_id' => $user->id,
            'action' => 'auth.login.dev',
            'target_type' => User::class,
            'target_id' => (string) $user->id,
            'ip_address' => $request->ip(),
            'details' => [
                'provider' => 'dev_sandbox',
                'role' => $role,
                'email' => $user->email,
            ],
        ]);

        $targetRoute = isset($config['target_route']) ? route($config['target_route']) : route('dashboard');

        return redirect()->to($targetRoute);
    }

    /**
     * Role definitions available in dev switcher.
     */
    protected function getAvailableRoles(): array
    {
        return [
            'single' => [
                [
                    'slug' => 'system-administrator',
                    'title' => 'System Administrator',
                    'email' => 'sysadmin@example.com',
                ],
                [
                    'slug' => 'iqa-staff',
                    'title' => 'IQA Member',
                    'email' => 'iqastaff@example.com',
                ],
                [
                    'slug' => 'accreditor',
                    'title' => 'AACCUP Accreditor',
                    'email' => 'accreditor@example.com',
                ],
                [
                    'slug' => 'university-administrator',
                    'title' => 'BU Executive',
                    'email' => 'buexecutive@example.com',
                ],
                [
                    'slug' => 'college-head',
                    'title' => 'College Head',
                    'email' => 'dean@example.com',
                ],
                [
                    'slug' => 'task-force-member',
                    'title' => 'Task Force',
                    'email' => 'tfmember@example.com',
                ],
            ],
            'multi' => [
                [
                    'slug' => 'iqa-staff-multi',
                    'primary' => 'IQA Member',
                    'secondary' => 'Task Force Member',
                    'badge' => 'DUAL',
                    'email' => 'iqastaff-multi@example.com',
                ],
                [
                    'slug' => 'dean-multi',
                    'primary' => 'College Head',
                    'secondary' => 'Task Force Member',
                    'badge' => 'DUAL',
                    'email' => 'dean-multi@example.com',
                ],
            ],
        ];
    }

    /**
     * Resolve configuration details for a given role slug.
     */
    protected function resolveRoleConfiguration(string $role): array
    {
        return match ($role) {
            'system-administrator', 'sysadmin', 'system_admin' => [
                'name' => 'System Administrator',
                'email' => 'sysadmin@example.com',
                'roles' => ['system_admin' => 'System Administrator'],
                'requires_college' => false,
                'target_route' => 'admin.dashboard',
            ],
            'iqa-staff', 'iqa-member', 'iqa_staff', 'iqa_member' => [
                'name' => 'IQA Staff User',
                'email' => 'iqastaff@example.com',
                'roles' => ['iqa_staff' => 'IQA Staff'],
                'requires_college' => false,
                'target_route' => 'iqa.dashboard',
            ],
            'accreditor', 'external-accreditor', 'external_accreditor' => [
                'name' => 'External Accreditor User',
                'email' => 'accreditor@example.com',
                'roles' => ['external_accreditor' => 'External Accreditor'],
                'requires_college' => false,
                'target_route' => 'external-accreditor.dashboard',
            ],
            'internal-accreditor', 'internal_accreditor' => [
                'name' => 'Internal Accreditor User',
                'email' => 'internal-accreditor@example.com',
                'roles' => ['internal_accreditor' => 'Internal Accreditor'],
                'requires_college' => false,
                'target_route' => 'internal-accreditor.dashboard',
            ],
            'university-administrator', 'bu-executive', 'bu_executive' => [
                'name' => 'BU Executive User',
                'email' => 'buexecutive@example.com',
                'roles' => ['bu_executive' => 'BU Executive'],
                'requires_college' => false,
                'target_route' => 'executive.dashboard',
            ],
            'college-head', 'dean', 'college_dean' => [
                'name' => 'Dean College of Science',
                'email' => 'dean@example.com',
                'roles' => ['college_dean' => 'College Dean'],
                'requires_college' => true,
                'target_route' => 'dean.dashboard',
            ],
            'task-force-member', 'task-force', 'task_force_member', 'tfmember' => [
                'name' => 'Task Force Member User',
                'email' => 'tfmember@example.com',
                'roles' => ['task_force_member' => 'Task Force Member'],
                'requires_college' => true,
                'target_route' => 'taskforce.dashboard',
            ],
            'iqa-staff-multi', 'iqa-member-multi' => [
                'name' => 'IQA & Task Force Lead',
                'email' => 'iqastaff-multi@example.com',
                'roles' => [
                    'iqa_staff' => 'IQA Staff',
                    'task_force_member' => 'Task Force Member',
                ],
                'requires_college' => true,
                'target_route' => 'iqa.dashboard',
            ],
            'dean-multi' => [
                'name' => 'Dean & Task Force Lead',
                'email' => 'dean-multi@example.com',
                'roles' => [
                    'college_dean' => 'College Dean',
                    'task_force_member' => 'Task Force Member',
                ],
                'requires_college' => true,
                'target_route' => 'dean.dashboard',
            ],
            default => [
                'name' => 'System Administrator',
                'email' => 'sysadmin@example.com',
                'roles' => ['system_admin' => 'System Administrator'],
                'requires_college' => false,
                'target_route' => 'admin.dashboard',
            ],
        };
    }
}
