<?php

use App\Livewire\Documents\DocumentWorkspace;
use App\Models\AuditLog;
use App\Models\College;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Office;
use App\Models\Program;
use App\Models\Role;
use App\Models\SelfSurveyArea;
use App\Models\SelfSurveyRating;
use App\Models\User;
use Database\Seeders\SelfSurveySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');

    Role::firstOrCreate(['role_name' => 'system-administrator'], ['description' => 'System Administrator']);
    Role::firstOrCreate(['role_name' => 'iqa-staff'], ['description' => 'IQA Member']);
    Role::firstOrCreate(['role_name' => 'college-head'], ['description' => 'College Head']);
    Role::firstOrCreate(['role_name' => 'task-force-member'], ['description' => 'Task Force Member']);
    Role::firstOrCreate(['role_name' => 'accreditor'], ['description' => 'Accreditor']);

    $this->seed(SelfSurveySeeder::class);
});

test('system administrator has access to all workspace tabs including institutional accreditation', function () {
    $adminRole = Role::where('role_name', 'system-administrator')->first();
    $admin = User::factory()->create(['role_id' => $adminRole->id]);

    $this->actingAs($admin);

    Livewire::test(DocumentWorkspace::class)
        ->assertSet('canAccessCommonDocs', true)
        ->assertSet('canAccessInstitutionalDocs', true)
        ->assertSet('isUnrestricted', true)
        ->call('switchTab', 'institutional-accreditation')
        ->assertSet('activeTab', 'institutional-accreditation')
        ->assertSee('Institutional Accreditation');
});

test('college head and task force member cannot access institutional accreditation tab', function () {
    $college = College::create(['name' => 'College of Arts and Letters', 'code' => 'CAL']);
    $program = Program::create(['name' => 'BA English', 'code' => 'BAENG', 'college_id' => $college->id]);

    $deanRole = Role::where('role_name', 'college-head')->first();
    $dean = User::factory()->create([
        'role_id' => $deanRole->id,
        'college_id' => $college->id,
    ]);

    $this->actingAs($dean);

    Livewire::test(DocumentWorkspace::class)
        ->assertSet('canAccessCommonDocs', true)
        ->assertSet('canAccessInstitutionalDocs', false)
        ->call('switchTab', 'institutional-accreditation')
        ->assertSet('activeTab', 'common-documents'); // Blocked, remains on allowed tab

    $tfRole = Role::where('role_name', 'task-force-member')->first();
    $tfUser = User::factory()->create([
        'role_id' => $tfRole->id,
        'college_id' => $college->id,
        'program_id' => $program->id,
    ]);

    $this->actingAs($tfUser);

    Livewire::test(DocumentWorkspace::class)
        ->assertSet('canAccessCommonDocs', true)
        ->assertSet('canAccessInstitutionalDocs', false)
        ->call('switchTab', 'institutional-accreditation')
        ->assertSet('activeTab', 'common-documents');
});

test('college head is strictly scoped to their own college and cannot switch outside', function () {
    $cal = College::create(['name' => 'College of Arts and Letters', 'code' => 'CAL']);
    $eng = College::create(['name' => 'College of Engineering', 'code' => 'ENG']);

    $deanRole = Role::where('role_name', 'college-head')->first();
    $dean = User::factory()->create([
        'role_id' => $deanRole->id,
        'college_id' => $cal->id,
    ]);

    $this->actingAs($dean);

    Livewire::test(DocumentWorkspace::class)
        ->assertSet('selectedCollegeId', $cal->id)
        ->call('selectCollege', $eng->id)
        ->assertSet('selectedCollegeId', $cal->id)
        ->set('selectedCollegeId', $eng->id)
        ->assertSet('selectedCollegeId', $cal->id); // Locked
});

test('uploading common document saves file and generates audit log', function () {
    $adminRole = Role::where('role_name', 'system-administrator')->first();
    $admin = User::factory()->create(['role_id' => $adminRole->id]);

    $office = Office::create(['name' => 'Office of the Vice President for Academic Affairs', 'code' => 'OVPAA']);
    $category = DocumentCategory::create(['name' => 'Policies and Guidelines', 'category_type' => 'common']);

    $this->actingAs($admin);

    $fakeFile = UploadedFile::fake()->create('academic_policy_2026.pdf', 1200, 'application/pdf');

    Livewire::test(DocumentWorkspace::class)
        ->call('openCommonUploadModal')
        ->set('uploadFile', $fakeFile)
        ->set('uploadTitle', 'Academic Policy 2026')
        ->set('uploadOfficeId', (string) $office->id)
        ->set('uploadCategoryId', (string) $category->id)
        ->set('uploadDescription', 'Test verification upload for common documents')
        ->call('uploadCommonDocument')
        ->assertHasNoErrors()
        ->assertSet('showCommonUploadModal', false);

    $doc = Document::where('title', 'Academic Policy 2026')->first();
    expect($doc)->not->toBeNull();
    expect($doc->office_id)->toBe($office->id);
    expect($doc->category_id)->toBe($category->id);
    expect($doc->file_extension)->toBe('PDF');

    // Verify AuditLog entry was written
    $log = AuditLog::where('target_id', $doc->id)->where('action', 'like', '%Academic Policy 2026%')->first();
    expect($log)->not->toBeNull();
    expect($log->user_id)->toBe($admin->id);
    expect($log->action)->toContain('Academic Policy 2026');
});

test('task force member can upload program evidence and links to accreditation', function () {
    $college = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $program = Program::create(['name' => 'BS Computer Science', 'code' => 'BSCS', 'college_id' => $college->id]);
    $tfRole = Role::where('role_name', 'task-force-member')->first();
    $tfUser = User::factory()->create([
        'role_id' => $tfRole->id,
        'college_id' => $college->id,
        'program_id' => $program->id,
    ]);

    $this->actingAs($tfUser);

    $fakeFile = UploadedFile::fake()->create('curriculum_matrix.pdf', 800, 'application/pdf');

    Livewire::test(DocumentWorkspace::class)
        ->set('selectedProgramId', $program->id)
        ->call('openEvidenceUploadModal')
        ->set('evidenceFile', $fakeFile)
        ->set('evidenceTitle', 'BSCS Curriculum Matrix')
        ->set('evidenceDescription', 'Official curriculum evidence')
        ->call('uploadEvidenceDocument')
        ->assertHasNoErrors()
        ->assertSet('showEvidenceUploadModal', false);

    $doc = Document::where('title', 'BSCS Curriculum Matrix')->first();
    expect($doc)->not->toBeNull();
    expect($doc->program_id)->toBe($program->id);
    expect($doc->status)->toBe('Pending');

    $log = AuditLog::where('target_id', $doc->id)->latest('timestamp')->first();
    expect($log)->not->toBeNull();
    expect($log->user_id)->toBe($tfUser->id);
});

test('self-survey rating calculates mean correctly excluding NA from denominator', function () {
    $adminRole = Role::where('role_name', 'system-administrator')->first();
    $admin = User::factory()->create(['role_id' => $adminRole->id]);

    $this->actingAs($admin);

    $area = SelfSurveyArea::where('code', 'area_i1')->first();
    $param = $area->parameters()->first();

    $ind1 = $param->indicators()->first();
    $ind2 = $param->indicators()->skip(1)->first();
    $ind3 = $param->indicators()->skip(2)->first();

    $component = Livewire::test(DocumentWorkspace::class)
        ->call('switchTab', 'institutional-accreditation')
        ->call('selectSurveyArea', $area->id)
        ->call('updateSurveyRating', $ind1->id, '5')
        ->call('updateSurveyRating', $ind2->id, '4')
        ->call('updateSurveyRating', $ind3->id, 'NA');

    // Verify ratings in database
    expect(SelfSurveyRating::where('indicator_id', $ind1->id)->value('rating'))->toBe(5);
    expect(SelfSurveyRating::where('indicator_id', $ind2->id)->value('rating'))->toBe(4);
    expect(SelfSurveyRating::where('indicator_id', $ind3->id)->value('rating'))->toBeNull(); // NA stored as null

    // Calculate section mean for these indicators: sum is 5 + 4 = 9, count is 2 (NA excluded). Mean = 4.50
    $indicators = collect([$ind1, $ind2, $ind3]);
    $mean = $component->instance()->calculateSectionMean($indicators);
    expect($mean)->toBe(4.50);
});

test('updating document status modifies document and writes audit log', function () {
    $adminRole = Role::where('role_name', 'system-administrator')->first();
    $admin = User::factory()->create(['role_id' => $adminRole->id]);

    $office = Office::create(['name' => 'OVPAA', 'code' => 'OVPAA']);
    $category = DocumentCategory::create(['name' => 'Policies', 'category_type' => 'common']);

    $doc = Document::create([
        'title' => 'Sample Status Doc',
        'file_path' => 'documents/sample.pdf',
        'uploaded_by' => $admin->id,
        'office_id' => $office->id,
        'category_id' => $category->id,
        'status' => 'Pending',
    ]);

    $this->actingAs($admin);

    Livewire::test(DocumentWorkspace::class)
        ->call('updateDocumentStatus', $doc->id, 'Verified')
        ->assertHasNoErrors();

    expect($doc->fresh()->status)->toBe('Verified');

    $log = AuditLog::where('target_id', $doc->id)->where('action', 'like', '%Verified%')->first();
    expect($log)->not->toBeNull();
    expect($log->user_id)->toBe($admin->id);
    expect($log->action)->toContain('Verified');
});

test('each of the 4 document workspace routes responds with 200 for its authorized role', function () {
    $roles = ['system-administrator', 'iqa-staff', 'college-head', 'task-force-member'];

    $college = College::create(['name' => 'College of Business', 'code' => 'CB']);
    $program = Program::create(['name' => 'BS Accountancy', 'code' => 'BSA', 'college_id' => $college->id]);

    foreach ($roles as $roleName) {
        $role = Role::where('role_name', $roleName)->first();
        $user = User::factory()->create([
            'role_id' => $role->id,
            'college_id' => $college->id,
            'program_id' => $program->id,
        ]);

        $response = $this->actingAs($user)->get(route("documents.{$roleName}"));
        $response->assertStatus(200);
        $response->assertSeeLivewire(DocumentWorkspace::class);
    }
});

test('unauthorized role cannot access mismatched document workspace route', function () {
    $college = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $deanRole = Role::where('role_name', 'college-head')->first();
    $dean = User::factory()->create([
        'role_id' => $deanRole->id,
        'college_id' => $college->id,
    ]);

    // College head trying to access system administrator document workspace
    $response = $this->actingAs($dean)->get(route('documents.system-administrator'));
    $response->assertStatus(403);
});
