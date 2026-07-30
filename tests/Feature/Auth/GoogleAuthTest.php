<?php

use App\Models\AuditLog;
use App\Models\Role;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

beforeEach(function () {
    Role::firstOrCreate(['role_name' => 'task-force'], ['description' => 'Task Force Member']);
    Role::firstOrCreate(['role_name' => 'iqa-admin'], ['description' => 'IQA Administrator']);
});

function mockGoogleUser(string $id, string $email, string $name)
{
    $abstractUser = Mockery::mock(\Laravel\Socialite\Two\User::class);
    $abstractUser->shouldReceive('getId')->andReturn($id);
    $abstractUser->shouldReceive('getEmail')->andReturn($email);
    $abstractUser->shouldReceive('getName')->andReturn($name);

    $provider = Mockery::mock(\Laravel\Socialite\Contracts\Provider::class);
    $provider->shouldReceive('user')->andReturn($abstractUser);

    \Laravel\Socialite\Facades\Socialite::shouldReceive('driver')->with('google')->andReturn($provider);
}

test('redirect to google auth page works', function () {
    $response = $this->get(route('auth.google'));
    $response->assertRedirect();
    expect($response->headers->get('Location'))->toContain('accounts.google.com');
});

test('pre-registered user with pending_activation is activated on google login', function () {
    $role = Role::where('role_name', 'task-force')->first();
    $user = User::create([
        'first_name' => 'Pending',
        'last_name' => 'User',
        'email' => 'juan.delacruz@bicol-u.edu.ph',
        'password' => bcrypt('password123'),
        'role_id' => $role->id,
        'status' => 'pending_activation',
    ]);

    mockGoogleUser('google-id-123', 'juan.delacruz@bicol-u.edu.ph', 'Juan Dela Cruz');

    $response = $this->get(route('auth.google.callback'));

    $response->assertRedirect(route('dashboard', absolute: false));
    $this->assertAuthenticatedAs($user);

    $user->refresh();
    expect($user->status)->toBe('active');
    expect($user->google_id)->toBe('google-id-123');
    expect($user->first_name)->toBe('Juan');
    expect($user->last_name)->toBe('Dela Cruz');
    expect($user->email_verified_at)->not->toBeNull();

    expect(AuditLog::where('user_id', $user->id)->where('action', 'GOOGLE_LOGIN')->exists())->toBeTrue();
});

test('new user with bicol university email is auto registered', function () {
    mockGoogleUser('google-id-456', 'maria.santos@bicol-u.edu.ph', 'Maria Santos');

    $response = $this->get(route('auth.google.callback'));

    $response->assertRedirect(route('dashboard', absolute: false));

    $newUser = User::where('email', 'maria.santos@bicol-u.edu.ph')->first();
    expect($newUser)->not->toBeNull();
    $this->assertAuthenticatedAs($newUser);

    expect($newUser->status)->toBe('active');
    expect($newUser->google_id)->toBe('google-id-456');
    expect($newUser->first_name)->toBe('Maria');
    expect($newUser->last_name)->toBe('Santos');
});

test('inactive account cannot log in via google auth', function () {
    $role = Role::where('role_name', 'task-force')->first();
    $user = User::create([
        'first_name' => 'Inactive',
        'last_name' => 'User',
        'email' => 'inactive.user@bicol-u.edu.ph',
        'password' => bcrypt('password123'),
        'role_id' => $role->id,
        'status' => 'inactive',
    ]);

    mockGoogleUser('google-id-789', 'inactive.user@bicol-u.edu.ph', 'Inactive User');

    $response = $this->get(route('auth.google.callback'));

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('disallowed email domain is rejected', function () {
    mockGoogleUser('google-id-999', 'external.person@gmail.com', 'External Person');

    $response = $this->get(route('auth.google.callback'));

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});
