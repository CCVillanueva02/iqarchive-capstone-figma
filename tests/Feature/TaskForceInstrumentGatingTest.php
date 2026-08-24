<?php

use App\Models\Accreditation;
use App\Models\College;
use App\Models\Instrument;
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

test('program controller returns instrument_verified false when accreditation is in preparation or setup stage', function () {
    $cs = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $bscs = Program::create(['name' => 'BS Computer Science', 'code' => 'BSCS', 'college_id' => $cs->id, 'accreditation_level' => 'Level III']);

    $tfRole = Role::where('role_name', 'task-force-member')->first();
    $tfUser = User::factory()->create([
        'role_id' => $tfRole->id,
        'college_id' => $cs->id,
        'program_id' => $bscs->id,
    ]);

    $taskForce = TaskForce::create([
        'name' => 'BSCS QA Task Force',
        'college_id' => $cs->id,
        'program_id' => $bscs->id,
        'status' => 'active',
        'created_by' => $tfUser->id,
    ]);

    // Create an accreditation in task_force_approved status (instrument not yet finalized by Dean)
    $accreditation = Accreditation::create([
        'program_id' => $bscs->id,
        'task_force_id' => $taskForce->id,
        'status' => 'task_force_approved',
        'target_date' => now()->addMonths(6),
        'created_by' => $tfUser->id,
    ]);

    $response = $this->actingAs($tfUser)->getJson(route('api.programs.index'));
    $response->assertOk();

    $data = $response->json();
    expect($data)->toHaveCount(1);
    expect($data[0]['instrument_verified'])->toBeFalse();
    expect($data[0]['accreditation_status'])->toBe('task_force_approved');
    expect($data[0]['accreditation_id'])->toBe($accreditation->id);
});

test('program controller returns instrument_verified true once dean finalizes instrument to document_preparation', function () {
    $cs = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $bscs = Program::create(['name' => 'BS Computer Science', 'code' => 'BSCS', 'college_id' => $cs->id, 'accreditation_level' => 'Level III']);

    $tfRole = Role::where('role_name', 'task-force-member')->first();
    $tfUser = User::factory()->create([
        'role_id' => $tfRole->id,
        'college_id' => $cs->id,
        'program_id' => $bscs->id,
    ]);

    $taskForce = TaskForce::create([
        'name' => 'BSCS QA Task Force',
        'college_id' => $cs->id,
        'program_id' => $bscs->id,
        'status' => 'active',
        'created_by' => $tfUser->id,
    ]);

    // Accreditation finalized by Dean -> document_preparation
    $accreditation = Accreditation::create([
        'program_id' => $bscs->id,
        'task_force_id' => $taskForce->id,
        'status' => 'document_preparation',
        'target_date' => now()->addMonths(6),
        'created_by' => $tfUser->id,
    ]);

    $response = $this->actingAs($tfUser)->getJson(route('api.programs.index'));
    $response->assertOk();

    $data = $response->json();
    expect($data)->toHaveCount(1);
    expect($data[0]['instrument_verified'])->toBeTrue();
    expect($data[0]['accreditation_status'])->toBe('document_preparation');
});
