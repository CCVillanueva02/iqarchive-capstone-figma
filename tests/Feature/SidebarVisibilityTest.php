<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed 6 target roles
    Role::firstOrCreate(['role_name' => 'system-administrator'], ['role_name' => 'system-administrator']);
    Role::firstOrCreate(['role_name' => 'iqa-staff'], ['role_name' => 'iqa-staff']);
    Role::firstOrCreate(['role_name' => 'accreditor'], ['role_name' => 'accreditor']);
    Role::firstOrCreate(['role_name' => 'university-administrator'], ['role_name' => 'university-administrator']);
    Role::firstOrCreate(['role_name' => 'college-head'], ['role_name' => 'college-head']);
    Role::firstOrCreate(['role_name' => 'task-force-member'], ['role_name' => 'task-force-member']);
});

function createUserWithRole(string $roleName): User
{
    $role = Role::where('role_name', $roleName)->first();

    return User::factory()->create([
        'role_id' => $role->id,
    ]);
}

test('college head can see Common Documents subtab link when on documents page', function () {
    $user = createUserWithRole('college-head');

    $response = $this->actingAs($user)
        ->get(route('documents.college-head', ['tab' => 'common-documents']));

    $response->assertOk();
    $response->assertSee('Common Documents');
});

test('task force member cannot see Task Forces sidebar link', function () {
    $user = createUserWithRole('task-force-member');

    $response = $this->actingAs($user)
        ->get(route('dashboard.task-force-member'));

    $response->assertOk();
    $response->assertDontSee(route('task-forces.index'));
});

test('iqa staff CAN see Task Forces sidebar link', function () {
    $user = createUserWithRole('iqa-staff');

    $response = $this->actingAs($user)
        ->get(route('dashboard.iqa-staff'));

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

test('college head CAN see Task Forces sidebar link', function () {
    $user = createUserWithRole('college-head');

    $response = $this->actingAs($user)
        ->get(route('dashboard.college-head'));

    $response->assertOk();
    $response->assertSee(route('task-forces.index'));
});

test('iqa staff can access Audit Trail without 403', function () {
    $user = createUserWithRole('iqa-staff');

    $response = $this->actingAs($user)
        ->get(route('audit-trail.iqa-staff'));

    $response->assertOk();
});

test('system administrator can access Audit Trail without 403', function () {
    $user = createUserWithRole('system-administrator');

    $response = $this->actingAs($user)
        ->get(route('reports.system-administrator'));

    $response->assertOk();
});

test('iqa staff and system administrator can access university analytics and reports without 403', function (string $roleName) {
    $user = createUserWithRole($roleName);

    $responseAnalytics = $this->actingAs($user)->get(route('analytics.university-administrator'));
    $responseAnalytics->assertOk();

    $responseReports = $this->actingAs($user)->get(route('reports.university-administrator'));
    $responseReports->assertOk();
})->with(['iqa-staff', 'system-administrator', 'university-administrator']);
