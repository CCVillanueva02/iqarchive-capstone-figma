<?php

use App\Livewire\SystemAdministrator\Accounts;
use App\Models\User;
use App\Models\Role;
use App\Models\College;
use Livewire\Livewire;

beforeEach(function () {
    $sysAdminRole = Role::firstOrCreate(['role_name' => 'system-administrator'], ['description' => 'System Admin']);
    $this->sysAdmin = User::factory()->create([
        'email' => 'admin@example.com',
        'role_id' => $sysAdminRole->id,
    ]);
});

test('college is required when pre-registering a user as program chair', function () {
    $programChairRole = Role::firstOrCreate(['role_name' => 'program-chair'], ['description' => 'Program Chair']);

    Livewire::actingAs($this->sysAdmin)
        ->test(Accounts::class)
        ->set('email', 'chairtest@bicol-u.edu.ph')
        ->set('role_id', $programChairRole->id)
        ->set('college_id', '')
        ->call('createAccount')
        ->assertHasErrors(['college_id' => 'required']);
});

test('college is required when pre-registering a user with additional IQA Member role', function () {
    $sysAdminRole = Role::firstOrCreate(['role_name' => 'system-administrator'], ['description' => 'System Admin']);
    $iqaMemberRole = Role::firstOrCreate(['role_name' => 'iqa-member'], ['description' => 'IQA Member']);

    Livewire::actingAs($this->sysAdmin)
        ->test(Accounts::class)
        ->set('email', 'multitest@bicol-u.edu.ph')
        ->set('role_id', $sysAdminRole->id)
        ->set('selected_role_ids', [$iqaMemberRole->id])
        ->set('college_id', '')
        ->call('createAccount')
        ->assertHasErrors(['college_id' => 'required']);
});

test('pre-registration succeeds when college is provided for requiring roles', function () {
    $collegeHeadRole = Role::firstOrCreate(['role_name' => 'college-head'], ['description' => 'College Head']);
    $college = College::create(['name' => 'BU College of Science', 'code' => 'CS']);

    Livewire::actingAs($this->sysAdmin)
        ->test(Accounts::class)
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
