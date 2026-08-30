<?php

use App\Models\Accreditation;
use App\Models\AccreditationDocumentLink;
use App\Models\AuditLog;
use App\Models\College;
use App\Models\ComplianceRequirement;
use App\Models\Document;
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
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['role_name' => 'system-administrator'], ['description' => 'System Administrator']);
    Role::firstOrCreate(['role_name' => 'iqa-staff'], ['description' => 'IQA Member']);
    Role::firstOrCreate(['role_name' => 'college-head'], ['description' => 'College Head']);
    Role::firstOrCreate(['role_name' => 'task-force-member'], ['description' => 'Task Force']);
});

test('task force upload is blocked when instrument is not yet verified by dean', function () {
    Storage::fake('public');

    $cs = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $bscs = Program::create(['name' => 'BS Computer Science', 'code' => 'BSCS', 'college_id' => $cs->id, 'accreditation_level' => 'Level III']);

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

    // Unverified accreditation
    $accreditation = Accreditation::create([
        'program_id' => $bscs->id,
        'task_force_id' => $taskForce->id,
        'status' => 'task_force_approved',
        'target_date' => now()->addMonths(6),
        'created_by' => $tfUser->id,
    ]);

    $fakeFile = UploadedFile::fake()->create('sample_policy.pdf', 1024, 'application/pdf');

    $response = $this->actingAs($tfUser)->postJson(route('api.accreditation.evidence.upload'), [
        'file' => $fakeFile,
        'program_id' => $bscs->id,
        'accreditation_id' => $accreditation->id,
        'criterion_code' => 'S.1',
        'title' => 'Sample VMGO Policy',
    ]);

    $response->assertStatus(403);
    $response->assertJsonFragment(['error' => 'Uploads are locked. The College Dean has not yet verified the accreditation instrument for this program.']);
});

test('task force can upload evidence once instrument is finalized to document_preparation', function () {
    Storage::fake('public');

    $cs = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $bscs = Program::create(['name' => 'BS Computer Science', 'code' => 'BSCS', 'college_id' => $cs->id, 'accreditation_level' => 'Level III']);

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

    // Finalized accreditation
    $accreditation = Accreditation::create([
        'program_id' => $bscs->id,
        'task_force_id' => $taskForce->id,
        'status' => 'document_preparation',
        'target_date' => now()->addMonths(6),
        'created_by' => $tfUser->id,
    ]);

    // Create instrument hierarchy
    $instrument = Instrument::create([
        'name' => 'BSCS Instrument',
        'code' => 'INST-BSCS-2026',
        'level' => 'Level III',
        'program_id' => $bscs->id,
        'accreditation_id' => $accreditation->id,
        'is_template' => false,
        'status' => 'active',
        'created_by' => $tfUser->id,
    ]);

    $area = InstrumentArea::create([
        'instrument_id' => $instrument->id,
        'name' => 'Vision, Mission, Goals and Objectives',
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
        'required_tags' => ['#BoardResolution'],
        'order' => 1,
    ]);

    $fakeFile = UploadedFile::fake()->create('vmgo_resolution.pdf', 2048, 'application/pdf');

    $response = $this->actingAs($tfUser)->postJson(route('api.accreditation.evidence.upload'), [
        'file' => $fakeFile,
        'program_id' => $bscs->id,
        'accreditation_id' => $accreditation->id,
        'instrument_criterion_id' => $criterion->id,
        'criterion_code' => 'S.1',
        'title' => 'BOR Resolution Approving VMGO',
        'description' => 'Official board resolution document.',
    ]);

    $response->assertStatus(201);
    $data = $response->json();

    expect($data['document']['name'])->toBe('BOR Resolution Approving VMGO');
    expect($data['document']['criterion_code'])->toBe('S.1');

    // Verify DB records created
    $doc = Document::where('title', 'BOR Resolution Approving VMGO')->first();
    expect($doc)->not->toBeNull();
    expect($doc->uploaded_by)->toBe($tfUser->id);
    expect($doc->program_id)->toBe($bscs->id);

    $complianceReq = ComplianceRequirement::where('accreditation_id', $accreditation->id)
        ->where('instrument_criterion_id', $criterion->id)
        ->first();
    expect($complianceReq)->not->toBeNull();

    $link = AccreditationDocumentLink::where('document_id', $doc->id)
        ->where('compliance_requirement_id', $complianceReq->id)
        ->first();
    expect($link)->not->toBeNull();

    // Verify AuditLog
    $audit = AuditLog::where('target_type', 'Document')->where('target_id', $doc->id)->first();
    expect($audit)->not->toBeNull();
    expect($audit->user_id)->toBe($tfUser->id);

    // Verify getProgramEvidence returns uploaded document for reload persistence
    $getRes = $this->actingAs($tfUser)->getJson(route('api.accreditation.evidence.index', ['programId' => $bscs->id]));
    $getRes->assertOk();
    $list = $getRes->json();
    expect($list)->toHaveCount(1);
    expect($list[0]['name'])->toBe('BOR Resolution Approving VMGO');
    expect($list[0]['criterion_code'])->toBe('S.1');
});

test('task force can submit evidence to dean and dean receives notification', function () {
    $cs = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $bscs = Program::create(['name' => 'BS Computer Science', 'code' => 'BSCS', 'college_id' => $cs->id, 'accreditation_level' => 'Level III']);

    $deanRole = Role::where('role_name', 'college-head')->first();
    $dean = User::factory()->create([
        'role_id' => $deanRole->id,
        'college_id' => $cs->id,
        'email' => 'csdean@example.com',
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
        'status' => 'document_preparation',
        'target_date' => now()->addMonths(6),
        'created_by' => $tfUser->id,
    ]);

    $response = $this->actingAs($tfUser)->postJson(route('api.accreditation.evidence.submit-to-dean'), [
        'program_id' => $bscs->id,
        'accreditation_id' => $accreditation->id,
        'notes' => 'All Area I documents completed.',
    ]);

    $response->assertOk();
    $response->assertJsonFragment(['accreditation_status' => 'dean_verification']);

    // Check accreditation updated
    $accreditation->refresh();
    expect($accreditation->status)->toBe('dean_verification');

    // Check Dean received notification
    $notification = Notification::where('user_id', $dean->id)->latest()->first();
    expect($notification)->not->toBeNull();
    expect($notification->message)->toContain('BS Computer Science');

    // Check AuditLog recorded
    $audit = AuditLog::where('target_type', 'Accreditation')->where('target_id', $accreditation->id)->latest()->first();
    expect($audit)->not->toBeNull();
    expect($audit->action)->toContain('submitted');
});
