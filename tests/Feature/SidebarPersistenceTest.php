<?php

/**
 * IQArchive Navigation Tests: Sidebar State Persistence
 *
 * Verifies backend Livewire Sidebar component lifecycle, session persistence
 * for accordion expansion states, and role-based initialization.
 */

use App\Livewire\Sidebar;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['role_name' => 'system-administrator'], ['role_name' => 'system-administrator']);
    Role::firstOrCreate(['role_name' => 'iqa-staff'], ['role_name' => 'iqa-staff']);
    Role::firstOrCreate(['role_name' => 'college-head'], ['role_name' => 'college-head']);
    Role::firstOrCreate(['role_name' => 'task-force-member'], ['role_name' => 'task-force-member']);
});

test('sidebar component mounts successfully and normalizes role', function () {
    $role = Role::where('role_name', 'iqa-staff')->first();
    $user = User::factory()->create(['role_id' => $role->id]);

    Livewire::actingAs($user)
        ->test(Sidebar::class)
        ->assertSet('role', 'iqa-staff')
        ->assertStatus(200);
});

test('toggling section persists to session', function () {
    $role = Role::where('role_name', 'iqa-staff')->first();
    $user = User::factory()->create(['role_id' => $role->id]);

    Livewire::actingAs($user)
        ->test(Sidebar::class)
        ->call('toggleSection', 'documents')
        ->assertSet('openSections', fn ($sections) => in_array('documents', $sections, true));

    expect(session('sidebar.open_sections'))->toContain('documents');
});

test('toggling section off removes it from session', function () {
    $role = Role::where('role_name', 'iqa-staff')->first();
    $user = User::factory()->create(['role_id' => $role->id]);

    session(['sidebar.open_sections' => ['documents', 'monitoring']]);

    Livewire::actingAs($user)
        ->test(Sidebar::class)
        ->call('toggleSection', 'documents')
        ->assertSet('openSections', ['monitoring']);

    expect(session('sidebar.open_sections'))->toBe(['monitoring']);
});

test('sidebar restores open sections from backend session on mount', function () {
    $role = Role::where('role_name', 'college-head')->first();
    $user = User::factory()->create(['role_id' => $role->id]);

    session(['sidebar.open_sections' => ['monitoring']]);

    Livewire::actingAs($user)
        ->test(Sidebar::class)
        ->assertSet('openSections', ['monitoring']);
});
