<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

dataset('dev_login_roles', [
    'System Administrator' => ['system-administrator', 'dashboard.system-administrator'],
    'IQA Staff' => ['iqa-staff', 'dashboard.iqa-staff'],
    'Accreditor' => ['accreditor', 'submissions.accreditor'],
    'BU Executive' => ['university-administrator', 'analytics.university-administrator'],
    'College Head (Dean)' => ['college-head', 'dashboard.college-head'],
    'Task Force Member' => ['task-force-member', 'dashboard.task-force-member'],
]);

test('dev login route successfully authenticates user and redirects to correct landing page', function (string $roleSlug, string $expectedRouteName) {
    $response = $this->get(route('dev.login', ['role' => $roleSlug]));

    $response->assertRedirect(route('dashboard'));

    // Assert user is logged in
    $this->assertAuthenticated();

    // Hitting dashboard follows redirect to role's designated homepage
    $dashboardResponse = $this->get(route('dashboard'));
    $dashboardResponse->assertRedirect(route($expectedRouteName));

    // Homepage renders HTTP 200 OK
    $homepageResponse = $this->get(route($expectedRouteName));
    $homepageResponse->assertOk();
})->with('dev_login_roles');
