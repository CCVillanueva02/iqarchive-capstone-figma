<?php

/**
 * ============================================================================
 * IQArchive v2 — Program Accreditation Feature Tests
 * ============================================================================
 * File: tests/Feature/ProgramAccreditationTest.php
 * Purpose: Verifies Program Accreditation 3-tier workspace navigation,
 *          IQA role boundaries, level-adaptive document types, and program registration.
 * Security Context: Server-side authorization gates, IQA role checks,
 *                   and multi-tenant college scoping.
 * ============================================================================
 */

namespace Tests\Feature;

use App\Models\College;
use App\Models\DocumentCategory;
use App\Models\Instrument;
use App\Models\InstrumentArea;
use App\Models\InstrumentCriterion;
use App\Models\InstrumentParameter;
use App\Models\Program;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ProgramAccreditationTest extends TestCase
{
    use RefreshDatabase;

    private User $iqaUser;
    private User $unauthorizedUser;
    private College $college;
    private Program $programLevel1;
    private Program $programLevel3;

    protected function setUp(): void
    {
        parent::setUp();

        $iqaRole = Role::create(['name' => 'iqa_staff', 'display_name' => 'IQA Staff']);
        $facultyRole = Role::create(['name' => 'faculty', 'display_name' => 'Faculty Member']);

        $this->college = College::create([
            'name' => 'BU GUBAT',
            'code' => 'BUGC',
            'campus' => 'BU GUBAT',
            'logo_image' => 'BUGC.png',
        ]);

        $this->programLevel1 = Program::create([
            'college_id' => $this->college->id,
            'name' => 'Bachelor of Science in Business Administration',
            'code' => 'BUGC-BSBA',
            'current_level' => 'Level 1',
        ]);

        $this->programLevel3 = Program::create([
            'college_id' => $this->college->id,
            'name' => 'Bachelor of Elementary Education',
            'code' => 'BUGC-BEED',
            'current_level' => 'Level 3',
        ]);

        $this->iqaUser = User::create([
            'name' => 'IQA Staff Member',
            'email' => 'iqa.staff@bicol-u.edu.ph',
            'status' => 'active',
        ]);
        $this->iqaUser->roles()->attach($iqaRole->id);

        $this->unauthorizedUser = User::create([
            'name' => 'Regular Faculty',
            'email' => 'faculty@bicol-u.edu.ph',
            'status' => 'active',
            'college_id' => $this->college->id,
        ]);
        $this->unauthorizedUser->roles()->attach($facultyRole->id);

        // Seed Master Instrument
        $inst = Instrument::create([
            'name' => 'AACCUP Undergraduate Master Survey Instrument',
            'code' => 'INST-AACCUP-UG',
            'type' => 'ug',
            'version' => '2026.1',
            'is_active' => true,
        ]);
        $area = InstrumentArea::create([
            'instrument_id' => $inst->id,
            'area_number' => 1,
            'name' => 'Vision, Mission, Goals, and Objectives',
        ]);
        $param = InstrumentParameter::create([
            'instrument_area_id' => $area->id,
            'parameter_letter' => 'A',
            'name' => 'Statement of VMGO',
        ]);
        InstrumentCriterion::create([
            'instrument_parameter_id' => $param->id,
            'benchmark_code' => 'S.1',
            'title' => 'The institution has a system of determining its Vision and Mission.',
            'type' => 'system',
        ]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/documents/program-accreditation');
        $response->assertRedirect('/login');
    }

    public function test_unauthorized_user_receives_403_forbidden(): void
    {
        $response = $this->actingAs($this->unauthorizedUser)
            ->get('/documents/program-accreditation');

        $response->assertStatus(403);
    }

    public function test_iqa_user_can_access_tier_1_college_grid(): void
    {
        $response = $this->actingAs($this->iqaUser)
            ->get('/documents/program-accreditation');

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Documents/Program-Accreditation/Index')
                ->where('currentTier', 1)
                ->has('colleges', 1)
                ->where('colleges.0.code', 'BUGC')
                ->where('colleges.0.programs_count', 2)
            );
    }

    public function test_iqa_user_can_access_tier_2_programs_grid_for_college(): void
    {
        $response = $this->actingAs($this->iqaUser)
            ->get("/documents/program-accreditation?college_id={$this->college->id}");

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Documents/Program-Accreditation/Index')
                ->where('currentTier', 2)
                ->where('selectedCollege.id', $this->college->id)
                ->has('programs', 2)
            );
    }

    public function test_level_1_program_resolves_ppp_document_type(): void
    {
        $response = $this->actingAs($this->iqaUser)
            ->get("/documents/program-accreditation?college_id={$this->college->id}&program_id={$this->programLevel1->id}");

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Documents/Program-Accreditation/Index')
                ->where('currentTier', 3)
                ->where('selectedProgram.id', $this->programLevel1->id)
                ->has('documentTypes', 4) // Supporting docs, self survey, compliance, PPP
                ->where('documentTypes.3.id', 'ppp')
            );
    }

    public function test_level_3_program_resolves_narrative_profile_document_type(): void
    {
        $response = $this->actingAs($this->iqaUser)
            ->get("/documents/program-accreditation?college_id={$this->college->id}&program_id={$this->programLevel3->id}");

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Documents/Program-Accreditation/Index')
                ->where('currentTier', 3)
                ->where('selectedProgram.id', $this->programLevel3->id)
                ->has('documentTypes', 5) // Supporting docs, self survey, compliance, PPP, Narrative Profile
                ->where('documentTypes.4.id', 'narrative-profile')
            );
    }

    public function test_iqa_user_can_register_new_degree_program(): void
    {
        $response = $this->actingAs($this->iqaUser)
            ->post('/documents/program-accreditation/programs', [
                'college_id' => $this->college->id,
                'name' => 'Bachelor in Agricultural Technology',
                'code' => 'BUGC-BAT',
                'current_level' => 'Candidate Status',
            ]);

        $response->assertRedirect("/documents/program-accreditation?college_id={$this->college->id}");
        $this->assertDatabaseHas('programs', [
            'college_id' => $this->college->id,
            'code' => 'BUGC-BAT',
            'name' => 'Bachelor in Agricultural Technology',
        ]);
    }

    public function test_tab_program_accreditation_redirects_to_program_accreditation_route(): void
    {
        $response = $this->actingAs($this->iqaUser)
            ->get('/documents?tab=program-accreditation');

        $response->assertRedirect(route('documents.program-accreditation'));
    }
}
