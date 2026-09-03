<?php

use App\Livewire\CollegeHead\DeanVerification;
use App\Models\Accreditation;
use App\Models\AccreditationDocumentLink;
use App\Models\AuditLog;
use App\Models\College;
use App\Models\ComplianceRequirement;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentReview;
use App\Models\Instrument;
use App\Models\InstrumentArea;
use App\Models\InstrumentCriterion;
use App\Models\InstrumentParameter;
use App\Models\Notification;
use App\Models\Program;
use App\Models\Role;
use App\Models\TaskForce;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['role_name' => 'system-administrator'], ['description' => 'System Administrator']);
    Role::firstOrCreate(['role_name' => 'iqa-staff'], ['description' => 'IQA Member']);
    Role::firstOrCreate(['role_name' => 'college-head'], ['description' => 'College Head']);
    Role::firstOrCreate(['role_name' => 'task-force-member'], ['description' => 'Task Force Member']);
});

test('dean from another college cannot access verification portal', function () {
    $cs = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $eng = College::create(['name' => 'College of Engineering', 'code' => 'ENG']);

    $bscs = Program::create(['name' => 'BS Computer Science', 'code' => 'BSCS', 'college_id' => $cs->id]);

    $engDeanRole = Role::where('role_name', 'college-head')->first();
    $engDean = User::factory()->create([
        'role_id' => $engDeanRole->id,
        'college_id' => $eng->id,
    ]);

    $accreditation = Accreditation::create([
        'program_id' => $bscs->id,
        'status' => 'dean_verification',
        'created_by' => $engDean->id,
    ]);

    $this->actingAs($engDean);

    Livewire::test(DeanVerification::class, ['accreditation' => $accreditation->id])
        ->assertForbidden();
});

test('college dean can view verification workspace and verify a document', function () {
    $cs = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $bscs = Program::create(['name' => 'BS Computer Science', 'code' => 'BSCS', 'college_id' => $cs->id]);

    $deanRole = Role::where('role_name', 'college-head')->first();
    $dean = User::factory()->create([
        'role_id' => $deanRole->id,
        'college_id' => $cs->id,
    ]);

    $tfRole = Role::where('role_name', 'task-force-member')->first();
    $tfUser = User::factory()->create([
        'role_id' => $tfRole->id,
        'college_id' => $cs->id,
        'program_id' => $bscs->id,
    ]);

    $taskForce = TaskForce::create([
        'name' => 'BSCS Task Force',
        'college_id' => $cs->id,
        'program_id' => $bscs->id,
        'status' => 'active',
        'created_by' => $tfUser->id,
    ]);

    $accreditation = Accreditation::create([
        'program_id' => $bscs->id,
        'task_force_id' => $taskForce->id,
        'status' => 'dean_verification',
        'created_by' => $tfUser->id,
    ]);

    $instrument = Instrument::create([
        'name' => 'BSCS Supporting Docs Instrument',
        'code' => 'INST-BSCS-SUPP-2026',
        'level' => 'Level III',
        'program_id' => $bscs->id,
        'accreditation_id' => $accreditation->id,
        'is_template' => false,
        'status' => 'active',
        'created_by' => $dean->id,
    ]);

    $area = InstrumentArea::create([
        'instrument_id' => $instrument->id,
        'name' => 'Vision, Mission, Goals, and Objectives',
        'code' => 'Area I',
        'order' => 1,
    ]);

    $param = InstrumentParameter::create([
        'instrument_area_id' => $area->id,
        'code' => 'Parameter A',
        'name' => 'Statement of VMGO',
        'order' => 1,
    ]);

    $criterion = InstrumentCriterion::create([
        'instrument_parameter_id' => $param->id,
        'section' => 'systems',
        'code' => 'S.1',
        'statement' => 'The institution has a system of determining its Vision and Mission.',
        'order' => 1,
    ]);

    $category = DocumentCategory::create(['name' => 'Accreditation Evidence']);

    $doc = Document::create([
        'title' => 'BOR Resolution 2026',
        'file_path' => 'documents/evidence/1/bor_res.pdf',
        'uploaded_by' => $tfUser->id,
        'program_id' => $bscs->id,
        'category_id' => $category->id,
        'status' => 'pending',
        'visibility' => 'private',
    ]);

    $compReq = ComplianceRequirement::create([
        'instrument_id' => $instrument->id,
        'accreditation_id' => $accreditation->id,
        'program_id' => $bscs->id,
        'instrument_criterion_id' => $criterion->id,
        'description' => 'VMGO Policy',
        'status' => 'pending',
    ]);

    AccreditationDocumentLink::create([
        'document_id' => $doc->id,
        'compliance_requirement_id' => $compReq->id,
    ]);

    $this->actingAs($dean);

    $httpRes = $this->get(route('accreditation.verify', $accreditation->id));
    $httpRes->assertOk();
    $httpRes->assertSee('BS Computer Science');

    Livewire::test(DeanVerification::class, ['accreditation' => $accreditation->id])
        ->assertSee('BS Computer Science')
        ->assertSee('BOR Resolution 2026')
        ->call('verifyDocument', $doc->id)
        ->assertDispatched('document-verified');

    $doc->refresh();
    expect($doc->status)->toBe('verified');
    expect($doc->confirmed_by)->toBe($dean->id);

    $audit = AuditLog::where('target_type', 'Document')->where('target_id', $doc->id)->first();
    expect($audit)->not->toBeNull();
    expect($audit->action)->toContain('verified');
});

test('dean can flag document for revisions with inline feedback', function () {
    $cs = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $bscs = Program::create(['name' => 'BS Computer Science', 'code' => 'BSCS', 'college_id' => $cs->id]);

    $deanRole = Role::where('role_name', 'college-head')->first();
    $dean = User::factory()->create([
        'role_id' => $deanRole->id,
        'college_id' => $cs->id,
    ]);

    $tfRole = Role::where('role_name', 'task-force-member')->first();
    $tfUser = User::factory()->create([
        'role_id' => $tfRole->id,
        'college_id' => $cs->id,
        'program_id' => $bscs->id,
    ]);

    $accreditation = Accreditation::create([
        'program_id' => $bscs->id,
        'status' => 'dean_verification',
        'created_by' => $tfUser->id,
    ]);

    $category = DocumentCategory::create(['name' => 'Accreditation Evidence']);

    $doc = Document::create([
        'title' => 'Curriculum Matrix Draft',
        'file_path' => 'documents/evidence/1/matrix.pdf',
        'uploaded_by' => $tfUser->id,
        'program_id' => $bscs->id,
        'category_id' => $category->id,
        'status' => 'pending',
        'visibility' => 'private',
    ]);

    $this->actingAs($dean);

    Livewire::test(DeanVerification::class, ['accreditation' => $accreditation->id])
        ->call('openFlagModal', $doc->id)
        ->set('revisionRemarks', 'Missing faculty department head signatures on page 3.')
        ->call('submitFlagDocument')
        ->assertDispatched('document-flagged');

    $doc->refresh();
    expect($doc->status)->toBe('needs_revision');

    $review = DocumentReview::where('document_id', $doc->id)->first();
    expect($review)->not->toBeNull();
    expect($review->remarks)->toBe('Missing faculty department head signatures on page 3.');

    $notification = Notification::where('user_id', $tfUser->id)->first();
    expect($notification)->not->toBeNull();
    expect($notification->message)->toContain('signatures');
});

test('dean can request revisions returning status to document_preparation', function () {
    $cs = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $bscs = Program::create(['name' => 'BS Computer Science', 'code' => 'BSCS', 'college_id' => $cs->id]);

    $deanRole = Role::where('role_name', 'college-head')->first();
    $dean = User::factory()->create([
        'role_id' => $deanRole->id,
        'college_id' => $cs->id,
    ]);

    $accreditation = Accreditation::create([
        'program_id' => $bscs->id,
        'status' => 'dean_verification',
        'created_by' => $dean->id,
    ]);

    $this->actingAs($dean);

    Livewire::test(DeanVerification::class, ['accreditation' => $accreditation->id])
        ->set('reworkSummaryNotes', 'Please revise Area III and re-upload syllabus matrices.')
        ->call('confirmRequestRevisions')
        ->assertRedirect(route('dashboard.college-head'));

    $accreditation->refresh();
    expect($accreditation->status)->toBe('document_preparation');
});

test('dean can submit to IQA transitioning status to submitted', function () {
    $cs = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $bscs = Program::create(['name' => 'BS Computer Science', 'code' => 'BSCS', 'college_id' => $cs->id]);

    $deanRole = Role::where('role_name', 'college-head')->first();
    $dean = User::factory()->create([
        'role_id' => $deanRole->id,
        'college_id' => $cs->id,
    ]);

    $iqaRole = Role::where('role_name', 'iqa-staff')->first();
    $iqaStaff = User::factory()->create([
        'role_id' => $iqaRole->id,
    ]);

    $accreditation = Accreditation::create([
        'program_id' => $bscs->id,
        'status' => 'dean_verification',
        'created_by' => $dean->id,
    ]);

    $this->actingAs($dean);

    Livewire::test(DeanVerification::class, ['accreditation' => $accreditation->id])
        ->set('signoffNotes', 'All 10 areas reviewed and verified.')
        ->call('confirmSubmitToIqa')
        ->assertRedirect(route('dashboard.college-head'));

    $accreditation->refresh();
    expect($accreditation->status)->toBe('submitted');

    $notification = Notification::where('user_id', $iqaStaff->id)->first();
    expect($notification)->not->toBeNull();
    expect($notification->message)->toContain('verified and submitted');
});
