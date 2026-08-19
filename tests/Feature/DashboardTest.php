<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));

    $expectedRoute = match ($user->role) {
        'iqa-staff', 'iqa-admin' => route('dashboard.iqa-staff'),
        'accreditor' => route('submissions.accreditor'),
        'university-administrator' => route('analytics.university-administrator'),
        'college-head' => route('dashboard.college-head'),
        default => route('dashboard.' . $user->role),
    };

    $response->assertRedirect($expectedRoute);
});
