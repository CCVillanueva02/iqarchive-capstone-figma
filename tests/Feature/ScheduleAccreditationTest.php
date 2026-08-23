<?php

use App\Livewire\Accreditation\ScheduleAccreditation;
use App\Livewire\Accreditation\VisitsIndex;
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

test('iqa staff can schedule an accreditation visit with program preview and dean notification', function () {
    $iqaRole = Role::where('role_name', 'iqa-staff')->first();
    $iqaUser = User::factory()->create(['role_id' => $iqaRole->id]);

    $deanRole = Role::where('role_name', 'college-head')->first();
    $college = College::create(['name' => 'College of Science', 'code' => 'CS', 'campus' => 'Legazpi West Campus']);
    $dean = User::factory()->create([
        'role_id' => $deanRole->id,
        'college_id' => $college->id,
    ]);

    $program = Program::create([
        'college_id' => $college->id,
        'name' => 'Bachelor of Science in Computer Science',
        'code' => 'BSCS',
        'accreditation_level' => 'Level I Accredited',
    ]);

    $component = Livewire::actingAs($iqaUser)
        ->test(ScheduleAccreditation::class)
        ->set('program_id', $program->id);

    // Verify parent college auto-selected
    $component->assertSet('college_id', $college->id);

    // Submit with date
    $targetDate = now()->addMonths(3)->format('Y-m-d');
    $component->set('target_date', $targetDate)
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('accreditation-scheduled')
        ->assertDispatched('close-flux-modal');

    // Verify Database entries
    $this->assertDatabaseHas('accreditations', [
        'program_id' => $program->id,
        'status' => 'scheduled',
        'created_by' => $iqaUser->id,
    ]);

    $this->assertDatabaseHas('audit_logs', [
        'user_id' => $iqaUser->id,
        'target_type' => 'Accreditation',
    ]);

    $this->assertDatabaseHas('notifications', [
        'user_id' => $dean->id,
        'type' => 'accreditation_scheduled',
    ]);

    // Check Timeline Stages in VisitsIndex
    $accreditation = Accreditation::first();
    $visitsComponent = Livewire::actingAs($iqaUser)
        ->test(VisitsIndex::class)
        ->call('openTimeline', $accreditation->id);

    $stages = $visitsComponent->get('timelineStages');

    // Step 1 should be completed
    expect($stages[0]['step'])->toBe(1);
    expect($stages[0]['status'])->toBe('completed');

    // Step 2 (Task Force Nomination) should be in_progress
    expect($stages[1]['step'])->toBe(2);
    expect($stages[1]['status'])->toBe('in_progress');

    // Step 3 (Task Force Official Assignment) should be pending
    expect($stages[2]['step'])->toBe(3);
    expect($stages[2]['status'])->toBe('pending');

    // Step 4 (Instrument Customization) should be pending
    expect($stages[3]['step'])->toBe(4);
    expect($stages[3]['status'])->toBe('pending');
});

test('unauthorized user cannot record an accreditation visit', function () {
    $accreditorRole = Role::where('role_name', 'accreditor')->first();
    $user = User::factory()->create(['role_id' => $accreditorRole->id]);

    $college = College::create(['name' => 'College of Arts and Letters', 'code' => 'CAL']);
    $program = Program::create([
        'college_id' => $college->id,
        'name' => 'Bachelor of Arts in English Language',
        'code' => 'BAEL',
        'accreditation_level' => 'Candidate Status',
    ]);

    Livewire::actingAs($user)
        ->test(ScheduleAccreditation::class)
        ->set('program_id', $program->id)
        ->set('target_date', now()->addMonths(2)->format('Y-m-d'))
        ->call('save')
        ->assertStatus(403);
});
