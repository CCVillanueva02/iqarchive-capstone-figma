<?php

use App\Models\College;
use App\Models\Role;
use App\Models\TaskForce;
use App\Models\TaskForceMember;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

test('roles table contains exactly 6 target roles', function () {
    $roles = Role::pluck('role_name')->toArray();

    expect($roles)->toHaveCount(6);
    expect($roles)->toContain('system-administrator');
    expect($roles)->toContain('iqa-staff');
    expect($roles)->toContain('accreditor');
    expect($roles)->toContain('university-administrator');
    expect($roles)->toContain('college-head');
    expect($roles)->toContain('task-force-member');

    expect($roles)->not()->toContain('iqa-admin');
    expect($roles)->not()->toContain('iqa-member');
    expect($roles)->not()->toContain('task-force');
    expect($roles)->not()->toContain('program-chair');
});

test('creating a task force automatically assigns college dean as lead', function () {
    $college = College::firstOrCreate(['code' => 'CS'], ['name' => 'College of Science']);
    $collegeHeadRole = Role::where('role_name', 'college-head')->first();

    $dean = User::factory()->create([
        'name' => 'Dean Science',
        'email' => 'dean.science@bicol-u.edu.ph',
        'role_id' => $collegeHeadRole->id,
        'college_id' => $college->id,
    ]);

    $taskForce = TaskForce::create([
        'name' => 'CS BSCS AACCUP Level III Task Force',
        'college_id' => $college->id,
        'status' => 'active',
        'created_by' => $dean->id,
    ]);

    $leadMember = TaskForceMember::where('task_force_id', $taskForce->id)
        ->where('user_id', $dean->id)
        ->first();

    expect($leadMember)->not->toBeNull();
    expect($leadMember->role_in_team)->toBe('lead');
    expect($dean->isTaskForceLead($taskForce->id))->toBeTrue();
});

test('manageTaskForceMembers gate restricts member management to iqa-staff and system-administrator', function () {
    $iqaStaff = User::whereHas('roleRelation', fn ($q) => $q->where('role_name', 'iqa-staff'))->first();
    $sysAdmin = User::whereHas('roleRelation', fn ($q) => $q->where('role_name', 'system-administrator'))->first();
    $dean = User::whereHas('roleRelation', fn ($q) => $q->where('role_name', 'college-head'))->first();

    expect(Gate::forUser($iqaStaff)->allows('manageTaskForceMembers'))->toBeTrue();
    expect(Gate::forUser($sysAdmin)->allows('manageTaskForceMembers'))->toBeTrue();
    expect(Gate::forUser($dean)->allows('manageTaskForceMembers'))->toBeFalse();
});

test('ensure user has role middleware protects role routes and sets active_role session', function () {
    $sysAdminRole = Role::where('role_name', 'system-administrator')->first();
    $sysAdmin = User::factory()->create(['role_id' => $sysAdminRole->id]);

    $deanRole = Role::where('role_name', 'college-head')->first();
    $dean = User::factory()->create(['role_id' => $deanRole->id]);

    // System administrator accessing sysadmin dashboard succeeds and sets active_role
    $this->actingAs($sysAdmin)
        ->get(route('dashboard.system-administrator'))
        ->assertStatus(200)
        ->assertSessionHas('active_role', 'system-administrator');

    // Dean accessing system administrator dashboard gets 403 Forbidden
    $this->actingAs($dean)
        ->get(route('dashboard.system-administrator'))
        ->assertStatus(403);

    // Dean accessing college head dashboard succeeds
    $this->actingAs($dean)
        ->get(route('dashboard.college-head'))
        ->assertStatus(200)
        ->assertSessionHas('active_role', 'college-head');
});

