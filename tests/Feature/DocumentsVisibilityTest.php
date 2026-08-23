<?php

use App\Models\College;
use App\Models\Program;
use App\Models\Role;
use App\Models\TaskForce;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['role_name' => 'system-administrator'], ['description' => 'System Administrator']);
    Role::firstOrCreate(['role_name' => 'iqa-staff'], ['description' => 'IQA Member']);
    Role::firstOrCreate(['role_name' => 'college-head'], ['description' => 'College Head']);
    Role::firstOrCreate(['role_name' => 'task-force-member'], ['description' => 'Task Force']);
});

test('iqa staff and sysadmin can see all colleges and all programs', function () {
    $cs = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $ceng = College::create(['name' => 'College of Engineering', 'code' => 'CENG']);

    Program::create(['name' => 'BS Computer Science', 'code' => 'BSCS', 'college_id' => $cs->id, 'accreditation_level' => 'Level III']);
    Program::create(['name' => 'BS Civil Engineering', 'code' => 'BSCE', 'college_id' => $ceng->id, 'accreditation_level' => 'Level II']);

    $sysadminRole = Role::where('role_name', 'system-administrator')->first();
    $sysadmin = User::factory()->create(['role_id' => $sysadminRole->id]);

    $iqaStaffRole = Role::where('role_name', 'iqa-staff')->first();
    $iqaStaff = User::factory()->create(['role_id' => $iqaStaffRole->id]);

    // Sysadmin check
    $collegesResponse = $this->actingAs($sysadmin)->getJson(route('api.colleges.index'));
    $collegesResponse->assertOk()->assertJsonCount(2);

    $programsResponse = $this->actingAs($sysadmin)->getJson(route('api.programs.index'));
    $programsResponse->assertOk()->assertJsonCount(2);

    // IQA Staff check
    $collegesResponse = $this->actingAs($iqaStaff)->getJson(route('api.colleges.index'));
    $collegesResponse->assertOk()->assertJsonCount(2);

    $programsResponse = $this->actingAs($iqaStaff)->getJson(route('api.programs.index'));
    $programsResponse->assertOk()->assertJsonCount(2);
});

test('college head only sees their assigned college and its programs', function () {
    $cs = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $ceng = College::create(['name' => 'College of Engineering', 'code' => 'CENG']);

    $bscs = Program::create(['name' => 'BS Computer Science', 'code' => 'BSCS', 'college_id' => $cs->id, 'accreditation_level' => 'Level III']);
    $bsit = Program::create(['name' => 'BS Information Technology', 'code' => 'BSIT', 'college_id' => $cs->id, 'accreditation_level' => 'Level I']);
    $bsce = Program::create(['name' => 'BS Civil Engineering', 'code' => 'BSCE', 'college_id' => $ceng->id, 'accreditation_level' => 'Level II']);

    $deanRole = Role::where('role_name', 'college-head')->first();
    $dean = User::factory()->create([
        'role_id' => $deanRole->id,
        'college_id' => $cs->id,
    ]);

    // College Head should only see CS
    $collegesResponse = $this->actingAs($dean)->getJson(route('api.colleges.index'));
    $collegesResponse->assertOk()->assertJsonCount(1);
    $collegesResponse->assertJsonFragment(['code' => 'CS']);
    $collegesResponse->assertJsonMissing(['code' => 'CENG']);

    // College Head should only see CS programs (BSCS, BSIT), not BSCE
    $programsResponse = $this->actingAs($dean)->getJson(route('api.programs.index'));
    $programsResponse->assertOk()->assertJsonCount(2);
    $programsResponse->assertJsonFragment(['code' => 'BSCS']);
    $programsResponse->assertJsonFragment(['code' => 'BSIT']);
    $programsResponse->assertJsonMissing(['code' => 'BSCE']);
});

test('task force member only sees their specific assigned college and program', function () {
    $cs = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $ceng = College::create(['name' => 'College of Engineering', 'code' => 'CENG']);

    $bscs = Program::create(['name' => 'BS Computer Science', 'code' => 'BSCS', 'college_id' => $cs->id, 'accreditation_level' => 'Level III']);
    $bsit = Program::create(['name' => 'BS Information Technology', 'code' => 'BSIT', 'college_id' => $cs->id, 'accreditation_level' => 'Level I']);
    $bsce = Program::create(['name' => 'BS Civil Engineering', 'code' => 'BSCE', 'college_id' => $ceng->id, 'accreditation_level' => 'Level II']);

    $tfRole = Role::where('role_name', 'task-force-member')->first();
    $tfUser = User::factory()->create([
        'role_id' => $tfRole->id,
        'college_id' => $cs->id,
        'program_id' => $bscs->id,
    ]);

    // Task Force should only see CS
    $collegesResponse = $this->actingAs($tfUser)->getJson(route('api.colleges.index'));
    $collegesResponse->assertOk()->assertJsonCount(1);
    $collegesResponse->assertJsonFragment(['code' => 'CS']);
    $collegesResponse->assertJsonMissing(['code' => 'CENG']);

    // Task Force should only see BSCS
    $programsResponse = $this->actingAs($tfUser)->getJson(route('api.programs.index'));
    $programsResponse->assertOk()->assertJsonCount(1);
    $programsResponse->assertJsonFragment(['code' => 'BSCS']);
    $programsResponse->assertJsonMissing(['code' => 'BSIT']);
    $programsResponse->assertJsonMissing(['code' => 'BSCE']);
});
