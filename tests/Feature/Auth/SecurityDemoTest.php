<?php

use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Features;

beforeEach(function () {
    $this->skipUnlessFortifyHas(Features::twoFactorAuthentication());

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);
});

test('two-factor authentication can be completed via recovery code', function () {
    $user = User::factory()->withTwoFactor()->create();

    // 1. Initial login attempt with correct email/password
    $response = $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    // Asserts redirect to the 2FA login page and user is not yet authenticated in the session
    $response->assertRedirect(route('two-factor.login'));
    $this->assertGuest();

    // 2. Submit an invalid recovery code
    $response = $this->post(route('two-factor.login.store'), [
        'recovery_code' => 'invalid-recovery-code',
    ]);

    // Fortify redirects back to the two-factor login challenge page on failure
    $response->assertRedirect(route('two-factor.login'));
    $this->assertGuest();

    // 3. Submit the valid recovery code
    $response = $this->post(route('two-factor.login.store'), [
        'recovery_code' => 'recovery-code-1',
    ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticatedAs($user);
});

test('login requests are rate limited after 5 attempts', function () {
    $user = User::factory()->create();

    // Send 5 incorrect attempts
    for ($i = 0; $i < 5; $i++) {
        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
        $response->assertSessionHasErrors('email');
    }

    // The 6th attempt should trigger the rate limiter (returns 429 status code)
    $response = $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(429);
});

test('two-factor login requests are rate limited after 5 attempts', function () {
    $user = User::factory()->withTwoFactor()->create();

    // Trigger the 2FA challenge flow
    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('two-factor.login'));

    // Send 5 incorrect recovery code attempts
    for ($i = 0; $i < 5; $i++) {
        $response = $this->post(route('two-factor.login.store'), [
            'recovery_code' => 'wrong-code-' . $i,
        ]);
        // Fortify redirects back to the two-factor login page on failure
        $response->assertRedirect(route('two-factor.login'));
    }

    // The 6th attempt should trigger the rate limiter
    $response = $this->post(route('two-factor.login.store'), [
        'recovery_code' => 'wrong-code-5',
    ]);

    // The rate limiter throws a Lockout exception / 429 response
    $response->assertStatus(429);
});
