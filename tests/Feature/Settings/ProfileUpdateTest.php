<?php

use App\Models\User;
use Livewire\Livewire;

test('profile page is displayed', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get(route('profile.edit'))->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test('pages::settings.profile')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    $user->refresh();

    expect($user->name)->toEqual('Test User');
    expect($user->email)->toEqual('test@example.com');
    expect($user->email_verified_at)->toBeNull();
});

test('email verification status is unchanged when email address is unchanged', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test('pages::settings.profile')
        ->set('name', 'Test User')
        ->set('email', $user->email)
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});

test('user can switch avatar to google profile picture', function () {
    $user = User::factory()->create([
        'google_avatar' => 'https://lh3.googleusercontent.com/a/google-avatar-url',
    ]);

    $this->actingAs($user);

    Livewire::test('pages::settings.profile')
        ->call('useGoogleAvatar')
        ->assertHasNoErrors();

    expect($user->refresh()->avatar)->toBe('https://lh3.googleusercontent.com/a/google-avatar-url');
    expect($user->avatar_url)->toBe('https://lh3.googleusercontent.com/a/google-avatar-url');
});

test('user can remove profile photo', function () {
    $user = User::factory()->create([
        'avatar' => 'avatars/test.jpg',
    ]);

    $this->actingAs($user);

    Livewire::test('pages::settings.profile')
        ->call('removeAvatar')
        ->assertHasNoErrors();

    expect($user->refresh()->avatar)->toBeNull();
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test('pages::settings.delete-user-modal')
        ->set('password', 'password')
        ->call('deleteUser');

    $response
        ->assertHasNoErrors()
        ->assertRedirect('/');

    expect($user->fresh())->toBeNull();
    expect(auth()->check())->toBeFalse();
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test('pages::settings.delete-user-modal')
        ->set('password', 'wrong-password')
        ->call('deleteUser');

    $response->assertHasErrors(['password']);

    expect($user->fresh())->not->toBeNull();
});