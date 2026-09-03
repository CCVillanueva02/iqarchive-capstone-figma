<?php

use App\Livewire\IqaAdmin\Accounts as IqaAccounts;
use App\Livewire\SystemAdministrator\Accounts as SysAdminAccounts;
use App\Models\College;
use App\Models\Program;
use App\Models\Role;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $sysAdminRole = Role::firstOrCreate(['role_name' => 'system-administrator'], ['description' => 'System Admin']);
    Role::firstOrCreate(['role_name' => 'iqa-staff'], ['description' => 'IQA Member']);
    Role::firstOrCreate(['role_name' => 'college-head'], ['description' => 'College Head']);
    Role::firstOrCreate(['role_name' => 'task-force-member'], ['description' => 'Task Force']);

    $this->sysAdmin = User::factory()->create([
        'email' => 'admin@example.com',
        'role_id' => $sysAdminRole->id,
    ]);

    $iqaRole = Role::where('role_name', 'iqa-staff')->first();
    $this->iqaUser = User::factory()->create([
        'email' => 'iqa@example.com',
        'role_id' => $iqaRole->id,
    ]);
});

test('college is required when pre-registering a user as college head', function () {
    $collegeHeadRole = Role::where('role_name', 'college-head')->first();

    Livewire::actingAs($this->sysAdmin)
        ->test(SysAdminAccounts::class)
        ->set('email', 'deantest@bicol-u.edu.ph')
        ->set('role_id', $collegeHeadRole->id)
        ->set('college_id', '')
        ->call('createAccount')
        ->assertHasErrors(['college_id' => 'required']);
});

test('pre-registration succeeds when college is provided for requiring roles', function () {
    $collegeHeadRole = Role::where('role_name', 'college-head')->first();
    $college = College::create(['name' => 'BU College of Science', 'code' => 'CS']);

    Livewire::actingAs($this->sysAdmin)
        ->test(SysAdminAccounts::class)
        ->set('email', 'deantest@bicol-u.edu.ph')
        ->set('role_id', $collegeHeadRole->id)
        ->set('college_id', $college->id)
        ->call('createAccount')
        ->assertHasNoErrors(['college_id']);

    $this->assertDatabaseHas('users', [
        'email' => 'deantest@bicol-u.edu.ph',
        'college_id' => $college->id,
    ]);
});

test('quick pre-register task force creates multiple members with pending activation status', function () {
    $college = College::create(['name' => 'College of Arts & Letters', 'code' => 'CAL']);
    $program = Program::create(['college_id' => $college->id, 'name' => 'AB Journalism', 'code' => 'ABJ']);
    $tfRole = Role::where('role_name', 'task-force-member')->first();

    $emails = "faculty1@bicol-u.edu.ph\nfaculty2@bicol-u.edu.ph, faculty3@bicol-u.edu.ph";

    Livewire::actingAs($this->iqaUser)
        ->test(IqaAccounts::class)
        ->call('openQuickTfModal')
        ->assertSet('showQuickTfModal', true)
        ->set('quick_tf_college_id', $college->id)
        ->set('quick_tf_program_id', $program->id)
        ->set('quick_tf_emails', $emails)
        ->call('quickRegisterTaskForce')
        ->assertSet('showQuickTfModal', false);

    $this->assertDatabaseHas('users', [
        'email' => 'faculty1@bicol-u.edu.ph',
        'role_id' => $tfRole->id,
        'college_id' => $college->id,
        'program_id' => $program->id,
        'status' => 'pending_activation',
    ]);

    $this->assertDatabaseHas('users', [
        'email' => 'faculty2@bicol-u.edu.ph',
        'role_id' => $tfRole->id,
        'college_id' => $college->id,
        'program_id' => $program->id,
        'status' => 'pending_activation',
    ]);

    $this->assertDatabaseHas('users', [
        'email' => 'faculty3@bicol-u.edu.ph',
        'role_id' => $tfRole->id,
        'status' => 'pending_activation',
    ]);
});
