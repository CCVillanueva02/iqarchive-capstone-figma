<?php

namespace Tests\Feature;

use App\Models\Accreditation;
use App\Models\AuditLog;
use App\Models\College;
use App\Models\Instrument;
use App\Models\InstrumentArea;
use App\Models\InstrumentParameter;
use App\Models\InstrumentCriterion;
use App\Models\Program;
use App\Models\Role;
use App\Models\TaskForce;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class InstrumentBuilderTest extends TestCase
{
    use RefreshDatabase;

    protected $iqaUser;
    protected $deanUser;
    protected $college;
    protected $program;
    protected $accreditation;

    protected function setUp(): void
    {
        parent::setUp();

        $iqaRole = Role::firstOrCreate(['role_name' => 'iqa-staff'], ['description' => 'IQA Staff']);
        $deanRole = Role::firstOrCreate(['role_name' => 'college-head'], ['description' => 'College Head / Dean']);

        $this->college = College::create([
            'name' => 'College of Science',
            'code' => 'CS',
            'campus' => 'Main Campus',
        ]);

        $this->program = Program::create([
            'college_id' => $this->college->id,
            'name' => 'BS Computer Science',
            'code' => 'BSCS',
            'accreditation_level' => 'Level III',
        ]);

        $this->iqaUser = User::create([
            'first_name' => 'IQA',
            'last_name' => 'Admin',
            'email' => 'iqa@bicol-u.edu.ph',
            'role_id' => $iqaRole->id,
            'status' => 'active',
            'password' => bcrypt('password'),
        ]);
        $this->iqaUser->roles()->sync([$iqaRole->id]);

        $this->deanUser = User::create([
            'first_name' => 'Dean',
            'last_name' => 'Science',
            'email' => 'dean.cs@bicol-u.edu.ph',
            'role_id' => $deanRole->id,
            'college_id' => $this->college->id,
            'status' => 'active',
            'password' => bcrypt('password'),
        ]);
        $this->deanUser->roles()->sync([$deanRole->id]);

        $taskForce = TaskForce::create([
            'name' => 'BSCS Accreditation Task Force',
            'college_id' => $this->college->id,
            'program_id' => $this->program->id,
            'status' => 'active',
            'created_by' => $this->iqaUser->id,
        ]);

        $this->accreditation = Accreditation::create([
            'program_id' => $this->program->id,
            'task_force_id' => $taskForce->id,
            'status' => 'task_force_approved',
            'target_date' => now()->addMonths(6),
            'created_by' => $this->iqaUser->id,
        ]);
    }

    public function test_iqa_staff_can_view_instruments_configuration_page()
    {
        $response = $this->actingAs($this->iqaUser)->get(route('configuration.instruments'));
        $response->assertStatus(200);
        $response->assertSee('Accreditation Instruments Builder');
    }

    public function test_iqa_staff_can_create_master_template()
    {
        $this->actingAs($this->iqaUser);

        Livewire::test(\App\Livewire\Configuration\Instruments::class)
            ->set('templateName', 'AACCUP Test Master 2026')
            ->set('templateCode', 'INST-TEST-2026')
            ->set('templateLevel', 'Level III')
            ->set('templateType', 'program')
            ->set('templateVersion', '2026.1')
            ->set('templateDescription', 'Test master template')
            ->call('saveTemplate')
            ->assertDispatched('swal');

        $this->assertDatabaseHas('instruments', [
            'code' => 'INST-TEST-2026',
            'name' => 'AACCUP Test Master 2026',
            'is_template' => true,
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $this->iqaUser->id,
            'target_type' => 'Instrument',
        ]);
    }

    public function test_iqa_staff_can_add_area_and_parameter_and_criterion_tags()
    {
        $this->actingAs($this->iqaUser);

        $instrument = Instrument::create([
            'name' => 'Sample Template',
            'code' => 'INST-SMP-2026',
            'level' => 'Level III',
            'is_template' => true,
            'status' => 'active',
        ]);

        $component = Livewire::test(\App\Livewire\Configuration\Instruments::class)
            ->call('selectInstrument', $instrument->id)
            ->set('areaCode', 'Area I')
            ->set('areaName', 'Vision, Mission, Goals, and Objectives')
            ->set('areaOrder', 1)
            ->set('areaWeight', 10.0)
            ->call('saveArea');

        $area = InstrumentArea::where('instrument_id', $instrument->id)->first();
        $this->assertNotNull($area);

        $component->call('selectArea', $area->id)
            ->set('parameterCode', 'Parameter A')
            ->set('parameterName', 'Statement of VMGO')
            ->set('parameterOrder', 1)
            ->call('saveParameter');

        $param = InstrumentParameter::where('instrument_area_id', $area->id)->first();
        $this->assertNotNull($param);

        $component->call('selectParameter', $param->id)
            ->set('activeSection', 'systems')
            ->set('criterionCode', 'S.1')
            ->set('criterionStatement', 'The institution has a defined VMGO process.')
            ->set('criterionTags', ['#UniversityManual', '#BoardResolution'])
            ->call('saveCriterion');

        $this->assertDatabaseHas('instrument_criteria', [
            'instrument_parameter_id' => $param->id,
            'code' => 'S.1',
        ]);
    }

    public function test_dean_can_access_instrument_customization_for_college_program()
    {
        // Seed a baseline master template
        Instrument::create([
            'name' => 'AACCUP Master Baseline',
            'code' => 'INST-AACCUP-UG-2026',
            'level' => 'Level III',
            'accreditation_type' => 'program',
            'is_template' => true,
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->deanUser)->get(route('accreditation.instrument', $this->accreditation->id));
        $response->assertStatus(200);
        $response->assertSee('BS Computer Science');
    }

    public function test_dean_can_add_custom_parameter_and_finalize_to_stage_5()
    {
        $this->actingAs($this->deanUser);

        // Seed master template with an area
        $master = Instrument::create([
            'name' => 'AACCUP Master Baseline',
            'code' => 'INST-AACCUP-UG-2026',
            'level' => 'Level III',
            'accreditation_type' => 'program',
            'is_template' => true,
            'status' => 'active',
        ]);
        $area = InstrumentArea::create([
            'instrument_id' => $master->id,
            'code' => 'Area I',
            'name' => 'VMGO',
            'order' => 1,
        ]);
        InstrumentParameter::create([
            'instrument_area_id' => $area->id,
            'code' => 'Parameter A',
            'name' => 'Statement of VMGO',
            'order' => 1,
        ]);

        $test = Livewire::test(\App\Livewire\CollegeHead\InstrumentCustomization::class, [
            'accreditation' => $this->accreditation->id,
        ]);

        $this->accreditation->refresh();
        $this->assertNotNull($this->accreditation->instrument);

        $firstArea = $this->accreditation->instrument->areas->first();
        $test->set('activeAreaId', $firstArea->id)
            ->set('paramCode', 'Parameter B')
            ->set('paramName', 'Industry Advisory Board')
            ->call('saveCustomParameter');

        $this->assertDatabaseHas('instrument_parameters', [
            'code' => 'Parameter B',
            'name' => 'Industry Advisory Board',
        ]);

        // Finalize instrument
        $test->call('finalizeInstrument');

        $this->accreditation->refresh();
        $this->assertEquals('document_preparation', $this->accreditation->status);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $this->deanUser->id,
            'target_type' => 'Accreditation',
            'target_id' => $this->accreditation->id,
        ]);
    }
}
