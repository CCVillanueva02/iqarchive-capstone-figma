<?php

/**
 * ============================================================================
 * IQArchive v2 — Audit Trail & Compliance Ledger Feature Tests
 * ============================================================================
 * File: tests/Feature/AuditTrailTest.php
 * Purpose: Verifies audit log viewing permissions, multi-tenancy college scoping,
 *          search/category filtering, and immutable model attributes.
 * Security Context: Role gating (system_admin, iqa_staff, college_dean only),
 *                   cross-tenant isolation, and non-repudiation.
 * ============================================================================
 */

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\College;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AuditTrailTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private User $iqaUser;
    private User $deanUser;
    private User $taskForceUser;
    private College $collegeA;
    private College $collegeB;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Roles
        $adminRole = Role::create(['name' => 'system_admin', 'display_name' => 'System Administrator']);
        $iqaRole = Role::create(['name' => 'iqa_staff', 'display_name' => 'IQA Staff']);
        $deanRole = Role::create(['name' => 'college_dean', 'display_name' => 'College Dean']);
        $tfRole = Role::create(['name' => 'task_force_member', 'display_name' => 'Task Force Member']);

        // Create Colleges
        $this->collegeA = College::create(['name' => 'College of Science', 'code' => 'CS']);
        $this->collegeB = College::create(['name' => 'College of Engineering', 'code' => 'CENG']);

        // Create Users
        $this->adminUser = User::create([
            'college_id' => null,
            'name' => 'SysAdmin Test',
            'email' => 'admin@bicol-u.edu.ph',
            'status' => 'active',
        ]);
        $this->adminUser->roles()->attach($adminRole->id);

        $this->iqaUser = User::create([
            'college_id' => null,
            'name' => 'IQA Officer Test',
            'email' => 'iqa@bicol-u.edu.ph',
            'status' => 'active',
        ]);
        $this->iqaUser->roles()->attach($iqaRole->id);

        $this->deanUser = User::create([
            'college_id' => $this->collegeA->id,
            'name' => 'Dean Science Test',
            'email' => 'dean.cs@bicol-u.edu.ph',
            'status' => 'active',
        ]);
        $this->deanUser->roles()->attach($deanRole->id);

        $this->taskForceUser = User::create([
            'college_id' => $this->collegeA->id,
            'name' => 'Task Force Test',
            'email' => 'tf@bicol-u.edu.ph',
            'status' => 'active',
        ]);
        $this->taskForceUser->roles()->attach($tfRole->id);
    }

    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get('/admin/audit-logs');
        $response->assertRedirect('/login');
    }

    public function test_unauthorized_task_force_member_receives_403_forbidden(): void
    {
        $response = $this->actingAs($this->taskForceUser)->get('/admin/audit-logs');
        $response->assertStatus(403);
    }

    public function test_system_admin_can_access_audit_logs(): void
    {
        AuditLog::create([
            'college_id' => null,
            'user_id' => $this->adminUser->id,
            'action' => 'auth.login',
            'target_type' => User::class,
            'target_id' => (string) $this->adminUser->id,
            'ip_address' => '127.0.0.1',
            'details' => ['provider' => 'google'],
        ]);

        $response = $this->actingAs($this->adminUser)->get('/admin/audit-logs');
        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Admin/AuditLogs/Index')
            ->has('auditLogs.data', 1)
            ->has('metrics')
            ->where('isUniversityWide', true)
        );
    }

    public function test_iqa_staff_can_access_audit_logs(): void
    {
        $response = $this->actingAs($this->iqaUser)->get('/admin/audit-logs');
        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Admin/AuditLogs/Index')
            ->where('isUniversityWide', true)
        );
    }

    public function test_college_dean_is_strictly_scoped_to_their_college(): void
    {
        // College A log (Dean's college)
        AuditLog::create([
            'college_id' => $this->collegeA->id,
            'user_id' => $this->deanUser->id,
            'action' => 'document.dean_approved',
            'target_type' => 'App\Models\Document',
            'target_id' => '101',
            'ip_address' => '192.168.1.1',
            'details' => ['title' => 'CS Syllabus'],
        ]);

        // College B log (Different college)
        AuditLog::create([
            'college_id' => $this->collegeB->id,
            'user_id' => $this->adminUser->id,
            'action' => 'document.dean_approved',
            'target_type' => 'App\Models\Document',
            'target_id' => '202',
            'ip_address' => '192.168.1.2',
            'details' => ['title' => 'Engineering Plan'],
        ]);

        $response = $this->actingAs($this->deanUser)->get('/admin/audit-logs');
        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Admin/AuditLogs/Index')
            ->has('auditLogs.data', 1)
            ->where('auditLogs.data.0.details.title', 'CS Syllabus')
            ->where('isUniversityWide', false)
        );
    }

    public function test_search_filter_returns_matching_entries(): void
    {
        AuditLog::create([
            'college_id' => $this->collegeA->id,
            'user_id' => $this->adminUser->id,
            'action' => 'auth.domain_rejected',
            'target_type' => 'App\Models\User',
            'target_id' => '999',
            'ip_address' => '10.0.0.55',
            'details' => ['email' => 'intruder@yahoo.com'],
        ]);

        AuditLog::create([
            'college_id' => $this->collegeA->id,
            'user_id' => $this->adminUser->id,
            'action' => 'auth.login',
            'target_type' => 'App\Models\User',
            'target_id' => (string) $this->adminUser->id,
            'ip_address' => '10.0.0.1',
            'details' => ['email' => 'admin@bicol-u.edu.ph'],
        ]);

        $response = $this->actingAs($this->adminUser)->get('/admin/audit-logs?search=domain_rejected');
        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Admin/AuditLogs/Index')
            ->has('auditLogs.data', 1)
            ->where('auditLogs.data.0.action', 'auth.domain_rejected')
        );
    }

    public function test_audit_log_model_computes_severity_and_category_accessors(): void
    {
        $log1 = AuditLog::create([
            'college_id' => null,
            'user_id' => $this->adminUser->id,
            'action' => 'auth.domain_rejected',
            'target_type' => 'App\Models\User',
            'target_id' => '1',
            'ip_address' => '127.0.0.1',
            'details' => [],
        ]);

        $log2 = AuditLog::create([
            'college_id' => null,
            'user_id' => $this->adminUser->id,
            'action' => 'document.dean_approved',
            'target_type' => 'App\Models\Document',
            'target_id' => '2',
            'ip_address' => '127.0.0.1',
            'details' => [],
        ]);

        $this->assertEquals('security', $log1->severity);
        $this->assertEquals('auth', $log1->category);

        $this->assertEquals('success', $log2->severity);
        $this->assertEquals('document', $log2->category);
    }
}
