<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['role_name' => 'system-administrator'], ['description' => 'System Administrator']);
    Role::firstOrCreate(['role_name' => 'iqa-staff'], ['description' => 'IQA Member']);
    Role::firstOrCreate(['role_name' => 'accreditor'], ['description' => 'AACCUP Accreditor']);
    Role::firstOrCreate(['role_name' => 'university-administrator'], ['description' => 'BU Executive']);
    Role::firstOrCreate(['role_name' => 'college-head'], ['description' => 'College Head']);
    Role::firstOrCreate(['role_name' => 'task-force-member'], ['description' => 'Task Force']);
});

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

dataset('system_roles_redirection', [
    'System Administrator' => ['system-administrator', 'dashboard.system-administrator'],
    'IQA Staff'            => ['iqa-staff', 'dashboard.iqa-staff'],
    'Accreditor'           => ['accreditor', 'submissions.accreditor'],
    'BU Executive'         => ['university-administrator', 'analytics.university-administrator'],
    'College Head'         => ['college-head', 'dashboard.college-head'],
    'Task Force Member'    => ['task-force-member', 'dashboard.task-force-member'],
]);

test('every role can log in and is redirected to their correct landing page', function (string $roleName, string $expectedRouteName) {
    $role = Role::where('role_name', $roleName)->first();

    $user = User::factory()->create([
        'role_id' => $role->id,
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    // Assert redirect to the role's designated homepage
    $response->assertRedirect(route($expectedRouteName));

    // Assert that navigating to their designated homepage succeeds with HTTP 200 OK
    $targetResponse = $this->actingAs($user)->get(route($expectedRouteName));
    $targetResponse->assertOk();
})->with('system_roles_redirection');
