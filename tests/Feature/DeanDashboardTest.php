<?php

use App\Livewire\CollegeHead\Dashboard;
use App\Models\Accreditation;
use App\Models\AuditLog;
use App\Models\College;
use App\Models\Notification;
use App\Models\Program;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['role_name' => 'system-administrator'], ['description' => 'System Administrator']);
    Role::firstOrCreate(['role_name' => 'iqa-staff'], ['description' => 'IQA Member']);
    Role::firstOrCreate(['role_name' => 'college-head'], ['description' => 'College Head']);
    Role::firstOrCreate(['role_name' => 'accreditor'], ['description' => 'Accreditor']);
});

test('dean can view their college dashboard with scoped kpis, active cycles, and programs directory', function () {
    $college = College::create(['name' => 'College of Science', 'code' => 'CS', 'campus' => 'Legazpi West Campus']);
    $otherCollege = College::create(['name' => 'College of Engineering', 'code' => 'CENG', 'campus' => 'East Campus']);

    $deanRole = Role::where('role_name', 'college-head')->first();
    $dean = User::factory()->create([
        'role_id' => $deanRole->id,
        'college_id' => $college->id,
    ]);

    $program1 = Program::create([
        'college_id' => $college->id,
        'name' => 'Bachelor of Science in Computer Science',
        'code' => 'BSCS',
        'accreditation_level' => 'Level I Accredited',
    ]);

    $program2 = Program::create([
        'college_id' => $college->id,
        'name' => 'Bachelor of Science in Information Technology',
        'code' => 'BSIT',
        'accreditation_level' => 'Candidate Status',
    ]);

    $otherProgram = Program::create([
        'college_id' => $otherCollege->id,
        'name' => 'Bachelor of Science in Civil Engineering',
        'code' => 'BSCE',
        'accreditation_level' => 'Level II Accredited',
    ]);

    // Schedule visit for BSCS only (so only BSCS is in Active Cycles table)
    $accreditation = Accreditation::create([
        'program_id' => $program1->id,
        'status' => 'scheduled',
        'target_date' => now()->addMonths(2)->format('Y-m-d'),
        'created_by' => $dean->id,
    ]);

    // Test Livewire component
    $component = Livewire::actingAs($dean)
        ->test(Dashboard::class);

    $component->assertSee('College of Science')
        ->assertSee('BSCS')
        ->assertSee('BSIT')
        ->assertDontSee('BSCE') // Scoped to CS college only
        ->assertSee('Stage 2 · Task Force Nomination');

    // Verify Active Cycles property only contains BSCS
    $activeProgs = $component->get('activeAccreditationPrograms');
    expect($activeProgs)->toHaveCount(1);
    expect($activeProgs->first()->id)->toBe($program1->id);

    // Verify All Programs property contains both BSCS and BSIT
    $allProgs = $component->get('allCollegePrograms');
    expect($allProgs)->toHaveCount(2);
});

test('dean can propose task force members and notify iqa', function () {
    $college = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $deanRole = Role::where('role_name', 'college-head')->first();
    $iqaRole = Role::where('role_name', 'iqa-staff')->first();

    $dean = User::factory()->create([
        'role_id' => $deanRole->id,
        'college_id' => $college->id,
    ]);

    $iqaUser = User::factory()->create([
        'role_id' => $iqaRole->id,
    ]);

    $program = Program::create([
        'college_id' => $college->id,
        'name' => 'Bachelor of Science in Biology',
        'code' => 'BSBIO',
        'accreditation_level' => 'Level I Accredited',
    ]);

    $accreditation = Accreditation::create([
        'program_id' => $program->id,
        'status' => 'scheduled',
        'target_date' => now()->addMonths(3)->format('Y-m-d'),
        'created_by' => $iqaUser->id,
    ]);

    $component = Livewire::actingAs($dean)
        ->test(Dashboard::class)
        ->call('openProposeModal', $accreditation->id)
        ->set('newName', 'Dr. Maria Santos')
        ->set('newEmail', 'maria.santos@bicol-u.edu.ph')
        ->set('newPhone', '09123456789')
        ->call('addMember')
        ->assertCount('proposedMembers', 1)
        ->call('submitProposal');

    // Verify DB update
    $accreditation->refresh();
    expect($accreditation->status)->toBe('task_force_setup');
    expect($accreditation->proposed_members)->toHaveCount(1);
    expect($accreditation->proposed_members[0]['name'])->toBe('Dr. Maria Santos');

    // Verify Audit Log
    $this->assertDatabaseHas('audit_logs', [
        'user_id' => $dean->id,
        'target_type' => 'Accreditation',
        'target_id' => $accreditation->id,
    ]);

    // Verify IQA Notification
    $this->assertDatabaseHas('notifications', [
        'user_id' => $iqaUser->id,
        'type' => 'task_force_proposed',
    ]);
});

test('dean can open and inspect the 7-stage lifecycle timeline and program history', function () {
    $college = College::create(['name' => 'College of Arts and Letters', 'code' => 'CAL']);
    $deanRole = Role::where('role_name', 'college-head')->first();
    $dean = User::factory()->create([
        'role_id' => $deanRole->id,
        'college_id' => $college->id,
    ]);

    $program = Program::create([
        'college_id' => $college->id,
        'name' => 'Bachelor of Arts in English',
        'code' => 'BAENG',
    ]);

    $accreditation = Accreditation::create([
        'program_id' => $program->id,
        'status' => 'scheduled',
        'target_date' => now()->addMonths(4)->format('Y-m-d'),
        'created_by' => $dean->id,
    ]);

    $component = Livewire::actingAs($dean)
        ->test(Dashboard::class)
        ->call('openTimeline', $accreditation->id)
        ->assertSet('showTimelineModal', true);

    $stages = $component->get('timelineStages');
    expect($stages[0]['status'])->toBe('completed');
    expect($stages[1]['status'])->toBe('in_progress');
    expect($stages[2]['status'])->toBe('pending');

    // Open Program History Modal
    $component->call('viewProgramHistory', $program->id)
        ->assertSet('showHistoryModal', true)
        ->assertSet('selectedProgramId', $program->id);
});
