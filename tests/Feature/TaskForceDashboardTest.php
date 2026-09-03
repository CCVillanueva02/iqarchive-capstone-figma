<?php

use App\Livewire\TaskForce\TaskForceDashboard;
use App\Models\Accreditation;
use App\Models\College;
use App\Models\Instrument;
use App\Models\InstrumentArea;
use App\Models\InstrumentCriterion;
use App\Models\InstrumentParameter;
use App\Models\Program;
use App\Models\Role;
use App\Models\TaskForce;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'RoleSeeder']);
});

test('task force member can view accreditation dashboard with program statistics', function () {
    $cs = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $bscs = Program::create(['name' => 'BS Computer Science', 'code' => 'BSCS', 'college_id' => $cs->id]);

    $tfRole = Role::where('role_name', 'task-force-member')->first();
    $tfUser = User::factory()->create([
        'role_id' => $tfRole->id,
        'college_id' => $cs->id,
        'program_id' => $bscs->id,
    ]);

    $taskForce = TaskForce::create([
        'college_id' => $cs->id,
        'program_id' => $bscs->id,
        'name' => 'CS QA Task Force',
    ]);
    $taskForce->members()->attach($tfUser->id, ['role_in_team' => 'member']);

    $instrument = Instrument::create([
        'code' => 'AACCUP-CS-L3',
        'name' => 'AACCUP Level III CS QA Instrument',
        'program_id' => $bscs->id,
    ]);
    $area1 = InstrumentArea::create(['instrument_id' => $instrument->id, 'code' => 'Area I', 'name' => 'VMGO', 'order_number' => 1]);
    $paramA = InstrumentParameter::create(['instrument_area_id' => $area1->id, 'code' => 'Parameter A', 'name' => 'Statement of VMGO', 'order_number' => 1]);
    $criterion1 = InstrumentCriterion::create(['instrument_parameter_id' => $paramA->id, 'code' => 'S.1', 'statement' => 'VMGO clearly stated.', 'section' => 'systems', 'order_number' => 1]);

    $accreditation = Accreditation::create([
        'program_id' => $bscs->id,
        'task_force_id' => $taskForce->id,
        'status' => 'document_preparation',
        'created_by' => $tfUser->id,
    ]);

    $this->actingAs($tfUser);

    $httpRes = $this->get(route('dashboard.task-force-member'));
    $httpRes->assertOk();
    $httpRes->assertSee('BS Computer Science');

    Livewire::test(TaskForceDashboard::class)
        ->assertSee('BS Computer Science')
        ->assertSee('CS QA Task Force')
        ->assertSee('Accreditation Instruments')
        ->assertSee('Supporting Documents');
});

test('task force member can submit evidence repository to college dean', function () {
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
        'status' => 'document_preparation',
        'created_by' => $dean->id,
    ]);

    $this->actingAs($tfUser);

    Livewire::test(TaskForceDashboard::class)
        ->call('openSubmitModal')
        ->assertSet('showSubmitModal', true)
        ->set('submissionRemarks', 'All criteria attached and verified by Task Force.')
        ->call('confirmSubmitToDean')
        ->assertSet('showSubmitModal', false);

    expect($accreditation->fresh()->status)->toBe('dean_verification');
});
