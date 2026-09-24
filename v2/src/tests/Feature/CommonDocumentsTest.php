<?php

/**
 * ============================================================================
 * IQArchive v2 — Common Documents Feature Tests
 * ============================================================================
 * File: tests/Feature/CommonDocumentsTest.php
 * Purpose: Verifies Common Documents repository browsing, office categorization,
 *          RBAC upload gating, validation, and pre-signed streaming URL generation.
 * Security Context: Server-side authorization gates, institutional college_id=null
 *                   scoping, and audit logging.
 * ============================================================================
 */

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\College;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\CommonDocumentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CommonDocumentsTest extends TestCase
{
    use RefreshDatabase;

    private User $iqaUser;
    private User $taskForceUser;
    private User $adminUser;
    private College $college;
    private DocumentCategory $hrdoCategory;
    private DocumentCategory $registrarCategory;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles
        $iqaRole = Role::create(['name' => 'iqa_staff', 'display_name' => 'IQA Staff']);
        $tfRole = Role::create(['name' => 'task_force_member', 'display_name' => 'Task Force Member']);
        $adminRole = Role::create(['name' => 'system_admin', 'display_name' => 'System Administrator']);

        // Seed College
        $this->college = College::create(['name' => 'College of Science', 'code' => 'CS']);

        // Seed Users
        $this->iqaUser = User::create([
            'college_id' => null,
            'name' => 'IQA Staff Test',
            'email' => 'iqatest@bicol-u.edu.ph',
            'status' => 'active',
        ]);
        $this->iqaUser->roles()->attach($iqaRole->id);

        $this->taskForceUser = User::create([
            'college_id' => $this->college->id,
            'name' => 'Task Force Member Test',
            'email' => 'tftest@bicol-u.edu.ph',
            'status' => 'active',
        ]);
        $this->taskForceUser->roles()->attach($tfRole->id);

        $this->adminUser = User::create([
            'college_id' => null,
            'name' => 'Sys Admin Test',
            'email' => 'admintest@bicol-u.edu.ph',
            'status' => 'active',
        ]);
        $this->adminUser->roles()->attach($adminRole->id);

        // Seed office categories via CommonDocumentSeeder
        $this->seed(CommonDocumentSeeder::class);

        $this->hrdoCategory = DocumentCategory::where('name', 'HRDO')->firstOrFail();
        $this->registrarCategory = DocumentCategory::where('name', 'University Registrar')->firstOrFail();
    }

    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get('/documents');
        $response->assertRedirect('/login');
    }

    public function test_iqa_staff_can_view_common_documents_workspace(): void
    {
        $response = $this->actingAs($this->iqaUser)->get("/documents?office_id={$this->hrdoCategory->id}");

        $response->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Documents/Common-Documents/Index')
                ->has('offices')
                ->where('canUpload', true)
                ->where('selectedOfficeId', $this->hrdoCategory->id)
                ->has('documents')
            );
    }

    public function test_task_force_member_can_view_workspace_with_can_upload_false(): void
    {
        $response = $this->actingAs($this->taskForceUser)->get('/documents');

        $response->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Documents/Common-Documents/Index')
                ->where('canUpload', false)
            );
    }

    public function test_iqa_staff_can_upload_common_document_with_null_college_id(): void
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->create('faculty_merit_policy.pdf', 512, 'application/pdf');

        $response = $this->actingAs($this->iqaUser)->post('/documents/common', [
            'title' => 'BU Faculty Merit System 2024',
            'office_id' => $this->hrdoCategory->id,
            'file' => $file,
            'description' => 'Guidelines for faculty promotion and merit evaluation.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('documents', [
            'title' => 'BU Faculty Merit System 2024',
            'original_filename' => 'faculty_merit_policy.pdf',
            'college_id' => null,
            'program_id' => null,
            'category_id' => $this->hrdoCategory->id,
            'user_id' => $this->iqaUser->id,
            'status' => 'draft',
            'visibility' => 'univ',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'document.upload.common',
            'user_id' => $this->iqaUser->id,
            'target_type' => Document::class,
        ]);
    }

    public function test_task_force_member_is_forbidden_from_uploading_common_documents(): void
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->create('unauthorized.pdf', 256, 'application/pdf');

        $response = $this->actingAs($this->taskForceUser)->post('/documents/common', [
            'title' => 'Unauthorized Document',
            'office_id' => $this->hrdoCategory->id,
            'file' => $file,
        ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('documents', [
            'title' => 'Unauthorized Document',
        ]);
    }

    public function test_upload_validation_rejects_non_pdf_files(): void
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->create('notes.txt', 128, 'text/plain');

        $response = $this->actingAs($this->iqaUser)->post('/documents/common', [
            'title' => 'Invalid Text File',
            'office_id' => $this->hrdoCategory->id,
            'file' => $file,
        ]);

        $response->assertSessionHasErrors(['file']);
    }

    public function test_can_filter_documents_by_office_and_search_query(): void
    {
        // Create 2 test documents under HRDO and 1 under Registrar
        Document::create([
            'college_id' => null,
            'program_id' => null,
            'category_id' => $this->hrdoCategory->id,
            'user_id' => $this->iqaUser->id,
            'title' => 'HRDO Plantilla Guidelines',
            'original_filename' => 'hrdo_plantilla.pdf',
            'file_path' => 'evidence/common/1/hash1.pdf',
            'file_hash' => hash('sha256', 'sample1'),
            'file_size_bytes' => 1024,
            'mime_type' => 'application/pdf',
            'status' => 'draft',
            'visibility' => 'univ',
        ]);

        Document::create([
            'college_id' => null,
            'program_id' => null,
            'category_id' => $this->hrdoCategory->id,
            'user_id' => $this->iqaUser->id,
            'title' => 'HRDO Recruitment Charter',
            'original_filename' => 'hrdo_recruit.pdf',
            'file_path' => 'evidence/common/1/hash2.pdf',
            'file_hash' => hash('sha256', 'sample2'),
            'file_size_bytes' => 2048,
            'mime_type' => 'application/pdf',
            'status' => 'iqa_appr',
            'visibility' => 'univ',
        ]);

        Document::create([
            'college_id' => null,
            'program_id' => null,
            'category_id' => $this->registrarCategory->id,
            'user_id' => $this->iqaUser->id,
            'title' => 'Registrar Academic Calendar 2025',
            'original_filename' => 'reg_calendar.pdf',
            'file_path' => 'evidence/common/2/hash3.pdf',
            'file_hash' => hash('sha256', 'sample3'),
            'file_size_bytes' => 4096,
            'mime_type' => 'application/pdf',
            'status' => 'draft',
            'visibility' => 'univ',
        ]);

        // Filter by HRDO
        $response = $this->actingAs($this->iqaUser)->get("/documents?office_id={$this->hrdoCategory->id}");
        $response->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Documents/Common-Documents/Index')
                ->has('documents', 2)
            );

        // Filter by HRDO and search "Recruitment"
        $response = $this->actingAs($this->iqaUser)->get("/documents?office_id={$this->hrdoCategory->id}&search=Recruitment");
        $response->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Documents/Common-Documents/Index')
                ->has('documents', 1)
                ->where('documents.0.title', 'HRDO Recruitment Charter')
            );
    }

    public function test_authenticated_user_can_request_download_url_for_common_document(): void
    {
        $doc = Document::create([
            'college_id' => null,
            'program_id' => null,
            'category_id' => $this->hrdoCategory->id,
            'user_id' => $this->iqaUser->id,
            'title' => 'Public Policy',
            'original_filename' => 'policy.pdf',
            'file_path' => 'evidence/common/sample.pdf',
            'file_hash' => hash('sha256', 'sample'),
            'file_size_bytes' => 1024,
            'mime_type' => 'application/pdf',
            'status' => 'draft',
            'visibility' => 'univ',
        ]);

        // Task force member can access download URL for university-wide common document
        $response = $this->actingAs($this->taskForceUser)->getJson("/documents/{$doc->id}/download");

        $response->assertOk()
            ->assertJsonStructure(['url']);

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'document.download',
            'user_id' => $this->taskForceUser->id,
            'target_id' => (string) $doc->id,
        ]);
    }

    public function test_iqa_staff_can_add_administrative_office(): void
    {
        $response = $this->actingAs($this->iqaUser)->post('/documents/offices', [
            'name' => 'Admissions and Registrar Services',
            'description' => 'Administers university student applications and scholastic records.',
        ]);

        $created = DocumentCategory::where('name', 'Admissions and Registrar Services')->first();
        $this->assertNotNull($created);
        $this->assertEquals('institutional', $created->scope);
        $this->assertEquals('Administers university student applications and scholastic records.', $created->description);

        $response->assertRedirect("/documents?office_id={$created->id}");
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'document_category.create',
            'user_id' => $this->iqaUser->id,
            'target_type' => DocumentCategory::class,
            'target_id' => (string) $created->id,
        ]);
    }

    public function test_system_admin_can_add_administrative_office(): void
    {
        $response = $this->actingAs($this->adminUser)->post('/documents/offices', [
            'name' => 'Information and Communications Technology Office',
            'description' => 'Oversees university IT systems and digital infrastructure.',
        ]);

        $created = DocumentCategory::where('name', 'Information and Communications Technology Office')->first();
        $this->assertNotNull($created);
        $response->assertRedirect("/documents?office_id={$created->id}");
    }

    public function test_task_force_member_is_forbidden_from_adding_office(): void
    {
        $response = $this->actingAs($this->taskForceUser)->post('/documents/offices', [
            'name' => 'Unauthorized Office Addition',
            'description' => 'Should fail with 403',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('document_categories', [
            'name' => 'Unauthorized Office Addition',
        ]);
    }

    public function test_office_name_must_be_unique_within_institutional_scope(): void
    {
        $response = $this->actingAs($this->iqaUser)->post('/documents/offices', [
            'name' => $this->hrdoCategory->name,
            'description' => 'Duplicate HRDO',
        ]);

        $response->assertSessionHasErrors(['name']);
    }
}
