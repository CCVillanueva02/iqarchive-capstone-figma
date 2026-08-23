<?php

use App\Livewire\CollegeHead\Dashboard as DeanDashboard;
use App\Livewire\TaskForce\TaskForceOverview;
use App\Models\Accreditation;
use App\Models\AuditLog;
use App\Models\College;
use App\Models\Program;
use App\Models\Role;
use App\Models\TaskForce;
use App\Models\TaskForceMember;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->sysAdminRole = Role::firstOrCreate(['role_name' => 'system-administrator'], ['description' => 'System Admin']);
    $this->iqaRole = Role::firstOrCreate(['role_name' => 'iqa-staff'], ['description' => 'IQA Staff']);
    $this->deanRole = Role::firstOrCreate(['role_name' => 'college-head'], ['description' => 'College Head / Dean']);
    $this->tfRole = Role::firstOrCreate(['role_name' => 'task-force-member'], ['description' => 'Task Force Member']);

    $this->college = College::create(['name' => 'College of Science', 'code' => 'CS']);
    $this->program = Program::create([
        'college_id' => $this->college->id,
        'name' => 'BS Computer Science',
        'code' => 'BSCS',
        'accreditation_level' => 'Level II Re-accredited',
    ]);

    $this->dean = User::factory()->create([
        'email' => 'dean.cs@bicol-u.edu.ph',
        'role_id' => $this->deanRole->id,
        'college_id' => $this->college->id,
        'first_name' => 'Dean',
        'last_name' => 'CS',
        'status' => 'active',
    ]);

    $this->iqaUser = User::factory()->create([
        'email' => 'iqa.eval@bicol-u.edu.ph',
        'role_id' => $this->iqaRole->id,
        'first_name' => 'IQA',
        'last_name' => 'Officer',
        'status' => 'active',
    ]);
});

test('dean nomination creates pending approval task force linked to accreditation', function () {
    $accreditation = Accreditation::create([
        'program_id' => $this->program->id,
        'status' => 'scheduled',
        'target_date' => now()->addMonths(6),
        'created_by' => $this->iqaUser->id,
    ]);

    $proposed = [
        ['name' => 'Prof. Alice Rivera', 'email' => 'alice.rivera@bicol-u.edu.ph', 'phone' => '09123456789'],
        ['name' => 'Dr. Bob Ramos', 'email' => 'bob.ramos@bicol-u.edu.ph', 'phone' => '09987654321'],
    ];

    Livewire::actingAs($this->dean)
        ->test(DeanDashboard::class)
        ->call('openProposeModal', $accreditation->id)
        ->set('proposedMembers', $proposed)
        ->call('submitProposal');

    $accreditation->refresh();
    expect($accreditation->status)->toBe('task_force_setup')
        ->and($accreditation->task_force_id)->not->toBeNull();

    $taskForce = TaskForce::find($accreditation->task_force_id);
    expect($taskForce)->not->toBeNull()
        ->and($taskForce->status)->toBe('pending_approval')
        ->and($taskForce->college_id)->toBe($this->college->id)
        ->and(count($taskForce->proposed_members))->toBe(2);
});

test('iqa approval pre-registers unlisted members and reactivates deactivated users', function () {
    // 1. Create a deactivated existing user
    $deactivatedUser = User::factory()->create([
        'email' => 'deactivated.faculty@bicol-u.edu.ph',
        'role_id' => $this->tfRole->id,
        'college_id' => $this->college->id,
        'first_name' => 'Old',
        'last_name' => 'Member',
        'status' => 'deactivated',
    ]);

    // 2. Create pending task force with 1 deactivated member and 1 brand new member
    $taskForce = TaskForce::create([
        'name' => 'BSCS Accreditation Task Force',
        'college_id' => $this->college->id,
        'program_id' => $this->program->id,
        'status' => 'pending_approval',
        'proposed_members' => [
            ['name' => 'Old Member', 'email' => 'deactivated.faculty@bicol-u.edu.ph', 'phone' => '09111111111'],
            ['name' => 'New Faculty', 'email' => 'new.faculty@bicol-u.edu.ph', 'phone' => '09222222222'],
        ],
        'created_by' => $this->dean->id,
    ]);

    $accreditation = Accreditation::create([
        'program_id' => $this->program->id,
        'task_force_id' => $taskForce->id,
        'status' => 'task_force_setup',
        'target_date' => now()->addMonths(6),
        'created_by' => $this->iqaUser->id,
    ]);

    // 3. IQA approves the task force
    Livewire::actingAs($this->iqaUser)
        ->test(TaskForceOverview::class)
        ->call('approveTaskForce', $taskForce->id);

    // 4. Assert deactivated user was reactivated to active
    $deactivatedUser->refresh();
    expect($deactivatedUser->status)->toBe('active');

    // 5. Assert new user was created in pending_activation
    $newUser = User::where('email', 'new.faculty@bicol-u.edu.ph')->first();
    expect($newUser)->not->toBeNull()
        ->and($newUser->status)->toBe('pending_activation')
        ->and($newUser->role_id)->toBe($this->tfRole->id)
        ->and($newUser->college_id)->toBe($this->college->id);

    // 6. Assert Dean is auto-assigned as Lead in task_force_members
    $deanMembership = TaskForceMember::where('task_force_id', $taskForce->id)
        ->where('user_id', $this->dean->id)
        ->first();
    expect($deanMembership)->not->toBeNull()
        ->and($deanMembership->role_in_team)->toBe('lead');

    // 7. Assert Task Force & Accreditation statuses updated
    $taskForce->refresh();
    $accreditation->refresh();
    expect($taskForce->status)->toBe('active')
        ->and($accreditation->status)->toBe('task_force_approved');

    // 8. Assert audit log
    $this->assertDatabaseHas('audit_logs', [
        'user_id' => $this->iqaUser->id,
        'target_type' => 'TaskForce',
        'target_id' => $taskForce->id,
    ]);
});
