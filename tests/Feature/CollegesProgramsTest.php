<?php

use App\Models\College;
use App\Models\Program;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['role_name' => 'system-administrator'], ['description' => 'System Administrator']);
    Role::firstOrCreate(['role_name' => 'iqa-staff'], ['description' => 'IQA Member']);
    Role::firstOrCreate(['role_name' => 'college-head'], ['description' => 'College Head']);
    Role::firstOrCreate(['role_name' => 'accreditor'], ['description' => 'Accreditor']);
});

function createTestUser(string $roleName): User
{
    $role = Role::where('role_name', $roleName)->first();
    return User::factory()->create([
        'role_id' => $role->id,
    ]);
}

test('iqa staff can access colleges and programs configuration page', function () {
    $user = createTestUser('iqa-staff');

    $response = $this->actingAs($user)
        ->get(route('configuration.colleges-programs'));

    $response->assertOk();
    $response->assertSee('Colleges & Programs');
    $response->assertSee('Add College');
});

test('college head can view colleges and programs page in read-only mode', function () {
    $user = createTestUser('college-head');

    $response = $this->actingAs($user)
        ->get(route('configuration.colleges-programs'));

    $response->assertOk();
    $response->assertSee('Colleges & Programs');
    $response->assertDontSee('Add College');
});

test('unauthorized role cannot view colleges and programs configuration', function () {
    $user = createTestUser('accreditor');

    $response = $this->actingAs($user)
        ->get(route('configuration.colleges-programs'));

    $response->assertForbidden();
});

test('iqa staff can create a college and program via livewire', function () {
    $user = createTestUser('iqa-staff');

    Livewire::actingAs($user)
        ->test(\App\Livewire\Configuration\CollegesPrograms::class)
        ->set('college_name', 'College of Information Technology')
        ->set('college_code', 'CIT')
        ->set('college_campus', 'Main Campus (Legazpi)')
        ->call('createCollege')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('colleges', [
        'name' => 'College of Information Technology',
        'code' => 'CIT',
    ]);

    $college = College::where('code', 'CIT')->first();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Configuration\CollegesPrograms::class)
        ->set('program_college_id', $college->id)
        ->set('program_name', 'Bachelor of Science in Information Technology')
        ->set('program_code', 'BSIT')
        ->set('program_accreditation_level', 'Level I Accredited')
        ->call('createProgram')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('programs', [
        'college_id' => $college->id,
        'name' => 'Bachelor of Science in Information Technology',
        'code' => 'BSIT',
        'accreditation_level' => 'Level I Accredited',
    ]);
});

test('college head cannot create college via livewire', function () {
    $user = createTestUser('college-head');

    Livewire::actingAs($user)
        ->test(\App\Livewire\Configuration\CollegesPrograms::class)
        ->set('college_name', 'Unauthorized College')
        ->set('college_code', 'UC')
        ->call('createCollege')
        ->assertStatus(403);
});

test('iqa staff can soft delete college and program', function () {
    $user = createTestUser('iqa-staff');

    $college = College::create(['name' => 'College of Education', 'code' => 'CED']);
    $program = Program::create([
        'college_id' => $college->id,
        'name' => 'Bachelor of Elementary Education',
        'code' => 'BEED',
        'accreditation_level' => 'Candidate Status',
    ]);

    Livewire::actingAs($user)
        ->test(\App\Livewire\Configuration\CollegesPrograms::class)
        ->set('programId', $program->id)
        ->call('deleteProgram')
        ->assertHasNoErrors();

    $this->assertSoftDeleted('programs', ['id' => $program->id]);

    Livewire::actingAs($user)
        ->test(\App\Livewire\Configuration\CollegesPrograms::class)
        ->set('collegeId', $college->id)
        ->call('deleteCollege')
        ->assertHasNoErrors();

    $this->assertSoftDeleted('colleges', ['id' => $college->id]);
});
