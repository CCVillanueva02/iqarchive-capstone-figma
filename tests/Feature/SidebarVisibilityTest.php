<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed roles
    Role::firstOrCreate(['role_name' => 'system-administrator'], ['role_name' => 'system-administrator']);
    Role::firstOrCreate(['role_name' => 'iqa-admin'], ['role_name' => 'iqa-admin']);
    Role::firstOrCreate(['role_name' => 'iqa-member'], ['role_name' => 'iqa-member']);
    Role::firstOrCreate(['role_name' => 'task-force'], ['role_name' => 'task-force']);
    Role::firstOrCreate(['role_name' => 'task-force-member'], ['role_name' => 'task-force-member']);
    Role::firstOrCreate(['role_name' => 'program-chair'], ['role_name' => 'program-chair']);
    Role::firstOrCreate(['role_name' => 'college-head'], ['role_name' => 'college-head']);
    Role::firstOrCreate(['role_name' => 'university-administrator'], ['role_name' => 'university-administrator']);
    Role::firstOrCreate(['role_name' => 'accreditor'], ['role_name' => 'accreditor']);
});

function createUserWithRole(string $roleName): User
{
    $role = Role::where('role_name', $roleName)->first();
    return User::factory()->create([
        'role_id' => $role->id,
    ]);
}

test('program chair can see Common Documents subtab link when on documents page', function () {
    $user = createUserWithRole('program-chair');

    $response = $this->actingAs($user)
        ->get(route('documents.program-chair', ['tab' => 'common-documents']));

    $response->assertOk();
    $response->assertSee('Common Documents');
});

test('system administrator cannot see Task Forces sidebar link', function () {
    $user = createUserWithRole('system-administrator');

    $response = $this->actingAs($user)
        ->get(route('dashboard.system-administrator'));

    $response->assertOk();
    $response->assertDontSee(route('task-forces.index'));
});

test('iqa member cannot see Task Forces sidebar link', function () {
    $user = createUserWithRole('iqa-member');

    $response = $this->actingAs($user)
        ->get(route('dashboard.iqa-member'));

    $response->assertOk();
    $response->assertDontSee(route('task-forces.index'));
});

test('task force lead cannot see Task Forces sidebar link', function () {
    $user = createUserWithRole('task-force');

    $response = $this->actingAs($user)
        ->get(route('dashboard.task-force'));

    $response->assertOk();
    $response->assertDontSee(route('task-forces.index'));
});

test('task force member cannot see Task Forces sidebar link', function () {
    $user = createUserWithRole('task-force-member');

    $response = $this->actingAs($user)
        ->get(route('dashboard.task-force-member'));

    $response->assertOk();
    $response->assertDontSee(route('task-forces.index'));
});

test('iqa admin CAN see Task Forces sidebar link', function () {
    $user = createUserWithRole('iqa-admin');

    $response = $this->actingAs($user)
        ->get(route('dashboard.iqa-admin'));

    $response->assertOk();
    $response->assertSee(route('task-forces.index'));
});

test('university admin CAN see Task Forces sidebar link', function () {
    $user = createUserWithRole('university-administrator');

    $response = $this->actingAs($user)
        ->get(route('analytics.university-administrator'));

    $response->assertOk();
    $response->assertSee(route('task-forces.index'));
});

test('program chair CAN see Task Forces sidebar link', function () {
    $user = createUserWithRole('program-chair');

    $response = $this->actingAs($user)
        ->get(route('dashboard.program-chair'));

    $response->assertOk();
    $response->assertSee(route('task-forces.index'));
});
