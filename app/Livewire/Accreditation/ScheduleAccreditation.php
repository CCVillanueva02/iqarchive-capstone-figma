<?php

namespace App\Livewire\Accreditation;

use App\Models\Accreditation;
use App\Models\AuditLog;
use App\Models\College;
use App\Models\Notification;
use App\Models\Program;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ScheduleAccreditation extends Component
{
    public $college_id = '';

    public $program_id = '';

    public $target_date = '';

    public $survey_end_date = '';

    public $showModal = false;

    public function rules()
    {
        return [
            'program_id' => 'required|exists:programs,id',
            'target_date' => 'required|date',
            'survey_end_date' => 'nullable|date|after_or_equal:target_date',
        ];
    }

    public function messages()
    {
        return [
            'program_id.required' => 'Please select an academic degree program.',
            'target_date.required' => 'Please designate a target start date for the visit.',
            'survey_end_date.after_or_equal' => 'The end date must be on or after the target start date.',
        ];
    }

    public function updatedProgramId($value)
    {
        if ($value) {
            $program = Program::with('college')->find($value);
            if ($program) {
                $this->college_id = $program->college_id;
            }
        }
    }

    public function updatedCollegeId($value)
    {
        if ($value && $this->program_id) {
            $program = Program::find($this->program_id);
            if ($program && $program->college_id != $value) {
                $this->program_id = '';
            }
        }
    }

    public function getSelectedProgramProperty()
    {
        if (! $this->program_id) {
            return null;
        }

        return Program::with(['college'])->find($this->program_id);
    }

    public function getSelectedCollegeDeanProperty()
    {
        $program = $this->selectedProgram;
        if (! $program || ! $program->college_id) {
            return null;
        }

        $deanRole = Role::where('role_name', 'college-head')->first();
        if (! $deanRole) {
            return null;
        }

        return User::where('college_id', $program->college_id)
            ->where('role_id', $deanRole->id)
            ->first();
    }

    /**
     * Record and schedule a new accreditation visit.
     *
     * Security Reasoning: Only authorized IQA Staff, IQA Admin, and System Administrators
     * are permitted to initiate official university accreditation surveys and instantiate
     * Task Force workspaces to prevent unverified compliance cycles and maintain institutional integrity.
     */
    public function save()
    {
        $user = Auth::user();
        if (! $user || ! in_array($user->role, ['iqa-staff', 'iqa-admin', 'system-administrator'])) {
            abort(403, 'Unauthorized to schedule an accreditation visit.');
        }

        $this->validate();

        $program = Program::with('college')->findOrFail($this->program_id);

        // Security Reasoning & Invariant: Prevent scheduling a new accreditation cycle if an active one already exists.
        $hasActiveAccreditation = Accreditation::where('program_id', $program->id)
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->exists();

        if ($hasActiveAccreditation) {
            $this->addError('program_id', "An active accreditation cycle is already ongoing for {$program->name}. You cannot schedule another visit until the current cycle concludes or is cancelled.");

            return;
        }

        // 1. Create Accreditation Visit record in scheduled state
        $accreditation = Accreditation::create([
            'program_id' => $program->id,
            'task_force_id' => null,
            'status' => 'scheduled',
            'target_date' => $this->target_date,
            'created_by' => $user->id,
        ]);

        // 4. Create Audit Log entry
        $formattedDate = Carbon::parse($this->target_date)->format('M d, Y');
        AuditLog::create([
            'user_id' => $user->id,
            'action' => "Recorded accreditation visit for {$program->name} targeted for {$formattedDate}",
            'target_type' => 'Accreditation',
            'target_id' => $accreditation->id,
            'timestamp' => now(),
        ]);

        // 5. Notify the College Dean
        $deanRole = Role::where('role_name', 'college-head')->first();
        if ($deanRole && $program->college_id) {
            $dean = User::where('college_id', $program->college_id)
                ->where('role_id', $deanRole->id)
                ->first();

            if ($dean) {
                Notification::create([
                    'user_id' => $dean->id,
                    'type' => 'accreditation_scheduled',
                    'message' => "Accreditation visit recorded for {$program->name}. Target survey: {$formattedDate}. Action Required: Propose Task Force roster.",
                    'is_read' => false,
                ]);
            }
        }

        $programName = $program->name;

        $this->reset([
            'college_id',
            'program_id',
            'target_date',
            'survey_end_date',
            'showModal',
        ]);

        $this->dispatch('accreditation-scheduled');
        $this->dispatch('close-flux-modal', 'schedule-accreditation');

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Accreditation Visit Recorded',
            'text' => "Official visit for {$programName} has been recorded. The College Dean has been notified to nominate the Task Force.",
        ]);
    }

    public function render()
    {
        $colleges = College::orderBy('name')->get();

        $programsQuery = Program::with('college')->orderBy('name');
        if (! empty($this->college_id)) {
            $programsQuery->where('college_id', $this->college_id);
        }
        $programs = $programsQuery->get();

        return view('livewire.accreditation.schedule-accreditation', [
            'colleges' => $colleges,
            'programs' => $programs,
            'selectedProgram' => $this->selectedProgram,
            'selectedCollegeDean' => $this->selectedCollegeDean,
        ]);
    }
}
