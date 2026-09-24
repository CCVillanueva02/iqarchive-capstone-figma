<?php

/**
 * ============================================================================
 * IQArchive v2 — Multi-Tenancy Scoping Test
 * ============================================================================
 * File: tests/Feature/MultiTenancyScopeTest.php
 * Purpose: Verifies CollegeScoped global scope, BelongsToCollege concern,
 *          MultiTenantScopeService, and cross-tenant leakage prevention.
 * Related Spec: v2/docs/db-design/database-design.md
 * Security Context: Rule 2 (Multi-tenancy scoping: Every query must scope by
 *                   college_id. Server-side authorization gates).
 * ============================================================================
 */

namespace Tests\Feature;

use App\Models\College;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Program;
use App\Models\Role;
use App\Models\Scopes\CollegeScoped;
use App\Models\User;
use App\Services\MultiTenantScopeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MultiTenancyScopeTest extends TestCase
{
    use RefreshDatabase;

    private College $collegeA;
    private College $collegeB;
    private Role $roleDean;
    private Role $roleIqa;
    private Role $roleAdmin;
    private User $userCollegeA;
    private User $userCollegeB;
    private User $userIqa;
    private User $userAdmin;
    private DocumentCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed colleges
        $this->collegeA = College::create(['name' => 'College of Science', 'code' => 'CS']);
        $this->collegeB = College::create(['name' => 'College of Engineering', 'code' => 'CENG']);

        // Seed roles
        $this->roleDean = Role::create(['name' => 'college_dean', 'display_name' => 'College Dean']);
        $this->roleIqa = Role::create(['name' => 'iqa_staff', 'display_name' => 'IQA Staff']);
        $this->roleAdmin = Role::create(['name' => 'system_admin', 'display_name' => 'System Administrator']);

        // Seed users
        $this->userCollegeA = User::create([
            'college_id' => $this->collegeA->id,
            'name' => 'Dean Science',
            'email' => 'dean.science@bicol-u.edu.ph',
            'status' => 'active',
        ]);
        $this->userCollegeA->roles()->attach($this->roleDean);

        $this->userCollegeB = User::create([
            'college_id' => $this->collegeB->id,
            'name' => 'Dean Engineering',
            'email' => 'dean.engineering@bicol-u.edu.ph',
            'status' => 'active',
        ]);
        $this->userCollegeB->roles()->attach($this->roleDean);

        $this->userIqa = User::create([
            'college_id' => null,
            'name' => 'IQA Officer',
            'email' => 'iqa@bicol-u.edu.ph',
            'status' => 'active',
        ]);
        $this->userIqa->roles()->attach($this->roleIqa);

        $this->userAdmin = User::create([
            'college_id' => null,
            'name' => 'Sys Admin',
            'email' => 'admin@bicol-u.edu.ph',
            'status' => 'active',
        ]);
        $this->userAdmin->roles()->attach($this->roleAdmin);

        $this->category = DocumentCategory::create([
            'name' => 'Curriculum & Syllabi',
            'scope' => 'program',
        ]);
    }

    /**
     * Test college-scoped user only sees their college's programs.
     */
    public function test_college_user_is_strictly_scoped_to_own_college_programs(): void
    {
        // Create programs in both colleges without active auth to avoid automatic scoping
        Program::withoutGlobalScope(CollegeScoped::class)->create([
            'college_id' => $this->collegeA->id,
            'name' => 'BS Computer Science',
            'code' => 'BSCS',
            'current_level' => 'Level III',
        ]);

        Program::withoutGlobalScope(CollegeScoped::class)->create([
            'college_id' => $this->collegeB->id,
            'name' => 'BS Civil Engineering',
            'code' => 'BSCE',
            'current_level' => 'Level II',
        ]);

        // Act as User from College A
        $this->actingAs($this->userCollegeA);

        $programs = Program::all();

        $this->assertCount(1, $programs);
        $this->assertEquals('BSCS', $programs->first()->code);
        $this->assertEquals($this->collegeA->id, $programs->first()->college_id);
    }

    /**
     * Test university-wide user can view programs across all colleges.
     */
    public function test_university_wide_user_can_view_all_programs(): void
    {
        Program::withoutGlobalScope(CollegeScoped::class)->create([
            'college_id' => $this->collegeA->id,
            'name' => 'BS Computer Science',
            'code' => 'BSCS',
            'current_level' => 'Level III',
        ]);

        Program::withoutGlobalScope(CollegeScoped::class)->create([
            'college_id' => $this->collegeB->id,
            'name' => 'BS Civil Engineering',
            'code' => 'BSCE',
            'current_level' => 'Level II',
        ]);

        // Act as IQA Staff (university-wide)
        $this->actingAs($this->userIqa);

        $this->assertCount(2, Program::all());

        // Act as System Admin (university-wide)
        $this->actingAs($this->userAdmin);

        $this->assertCount(2, Program::all());
    }

    /**
     * Test college-scoped user only sees their college's documents.
     */
    public function test_college_user_only_sees_own_documents(): void
    {
        Document::withoutGlobalScope(CollegeScoped::class)->create([
            'college_id' => $this->collegeA->id,
            'category_id' => $this->category->id,
            'user_id' => $this->userCollegeA->id,
            'title' => 'Science Syllabus 2026',
            'original_filename' => 'sci_syl.pdf',
            'file_path' => 'evidence/1/null/hash1.pdf',
            'file_hash' => hash('sha256', 'content1'),
            'file_size_bytes' => 1024,
            'mime_type' => 'application/pdf',
        ]);

        Document::withoutGlobalScope(CollegeScoped::class)->create([
            'college_id' => $this->collegeB->id,
            'category_id' => $this->category->id,
            'user_id' => $this->userCollegeB->id,
            'title' => 'Engineering Syllabus 2026',
            'original_filename' => 'eng_syl.pdf',
            'file_path' => 'evidence/2/null/hash2.pdf',
            'file_hash' => hash('sha256', 'content2'),
            'file_size_bytes' => 2048,
            'mime_type' => 'application/pdf',
        ]);

        // Act as User from College A
        $this->actingAs($this->userCollegeA);

        $docs = Document::all();
        $this->assertCount(1, $docs);
        $this->assertEquals('Science Syllabus 2026', $docs->first()->title);

        // Act as User from College B
        $this->actingAs($this->userCollegeB);

        $docsB = Document::all();
        $this->assertCount(1, $docsB);
        $this->assertEquals('Engineering Syllabus 2026', $docsB->first()->title);
    }

    /**
     * Test creating a document automatically assigns the user's college_id.
     */
    public function test_creating_tenant_record_auto_populates_college_id(): void
    {
        $this->actingAs($this->userCollegeA);

        $document = Document::create([
            'category_id' => $this->category->id,
            'user_id' => $this->userCollegeA->id,
            'title' => 'Auto Populated Document',
            'original_filename' => 'auto.pdf',
            'file_path' => 'evidence/auto.pdf',
            'file_hash' => hash('sha256', 'auto'),
            'file_size_bytes' => 512,
            'mime_type' => 'application/pdf',
        ]);

        $this->assertEquals($this->collegeA->id, $document->college_id);
    }

    /**
     * Test explicit unscoped query retrieves all records regardless of user.
     */
    public function test_without_global_scope_retrieves_all_records(): void
    {
        Program::withoutGlobalScope(CollegeScoped::class)->create([
            'college_id' => $this->collegeA->id,
            'name' => 'Program A',
            'code' => 'PA',
            'current_level' => 'Level I',
        ]);

        Program::withoutGlobalScope(CollegeScoped::class)->create([
            'college_id' => $this->collegeB->id,
            'name' => 'Program B',
            'code' => 'PB',
            'current_level' => 'Level I',
        ]);

        $this->actingAs($this->userCollegeA);

        $this->assertCount(1, Program::all());
        $this->assertCount(2, Program::withoutGlobalScope(CollegeScoped::class)->get());
    }

    /**
     * Test MultiTenantScopeService helper methods.
     */
    public function test_multi_tenant_scope_service_logic(): void
    {
        $service = app(MultiTenantScopeService::class);

        $this->assertTrue($service->isUniversityWideUser($this->userIqa));
        $this->assertTrue($service->isUniversityWideUser($this->userAdmin));
        $this->assertFalse($service->isUniversityWideUser($this->userCollegeA));

        $this->assertTrue($service->isCollegeScopedUser($this->userCollegeA));
        $this->assertFalse($service->isCollegeScopedUser($this->userIqa));

        $this->assertEquals($this->collegeA->id, $service->getEnforcedCollegeId($this->userCollegeA));
        $this->assertNull($service->getEnforcedCollegeId($this->userIqa));

        $this->assertTrue($service->canAccessCollege($this->userCollegeA, $this->collegeA));
        $this->assertFalse($service->canAccessCollege($this->userCollegeA, $this->collegeB));
        $this->assertTrue($service->canAccessCollege($this->userIqa, $this->collegeB));
    }

    /**
     * Test ProgramPolicy authorizes access by college and denies cross-tenant access.
     */
    public function test_program_policy_enforces_tenant_isolation(): void
    {
        $programA = Program::withoutGlobalScope(CollegeScoped::class)->create([
            'college_id' => $this->collegeA->id,
            'name' => 'Program A',
            'code' => 'PA',
            'current_level' => 'Level I',
        ]);

        $policy = app(\App\Policies\ProgramPolicy::class);

        // College A Dean can view Program A
        $this->assertTrue($policy->view($this->userCollegeA, $programA));

        // College B Dean CANNOT view Program A
        $this->assertFalse($policy->view($this->userCollegeB, $programA));

        // IQA and SysAdmin can view Program A
        $this->assertTrue($policy->view($this->userIqa, $programA));
        $this->assertTrue($policy->view($this->userAdmin, $programA));
    }

    /**
     * Test DocumentPolicy enforces two-tier authorization gates and college isolation.
     */
    public function test_document_policy_enforces_two_tier_and_tenant_gates(): void
    {
        $docA = Document::withoutGlobalScope(CollegeScoped::class)->create([
            'college_id' => $this->collegeA->id,
            'category_id' => $this->category->id,
            'user_id' => $this->userCollegeA->id,
            'title' => 'Document A',
            'original_filename' => 'docA.pdf',
            'file_path' => 'evidence/docA.pdf',
            'file_hash' => hash('sha256', 'docA'),
            'file_size_bytes' => 1024,
            'mime_type' => 'application/pdf',
        ]);

        $policy = app(\App\Policies\DocumentPolicy::class);

        // View checks: Same college allows, cross-college denies, IQA allows
        $this->assertTrue($policy->view($this->userCollegeA, $docA));
        $this->assertFalse($policy->view($this->userCollegeB, $docA));
        $this->assertTrue($policy->view($this->userIqa, $docA));

        // Tier 1 Endorse: College A Dean can endorse, College B Dean cannot, IQA cannot
        $this->assertTrue($policy->endorse($this->userCollegeA, $docA));
        $this->assertFalse($policy->endorse($this->userCollegeB, $docA));
        $this->assertFalse($policy->endorse($this->userIqa, $docA));

        // Tier 2 Consolidate: Only IQA can consolidate
        $this->assertTrue($policy->consolidate($this->userIqa, $docA));
        $this->assertFalse($policy->consolidate($this->userCollegeA, $docA));
    }
}

