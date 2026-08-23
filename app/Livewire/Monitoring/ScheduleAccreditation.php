<?php

namespace App\Livewire\Monitoring;

use App\Models\Accreditation;
use App\Models\Program;
use App\Models\TaskForce;
use App\Models\AuditLog;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ScheduleAccreditation extends Component
{
    public $program_id;
    public $target_date;

    public $showModal = false;

    public function rules()
    {
        return [
            'program_id' => 'required|exists:programs,id',
            'target_date' => 'nullable|date',
        ];
    }

    public function save()
    {
        $this->validate();

        // 1. Create Task Force placeholder
        $program = Program::find($this->program_id);
        $tfName = $program->code . ' Accreditation ' . date('Y');
        
        $taskForce = TaskForce::create([
            'name' => $tfName,
            'college_id' => $program->college_id,
            'program_id' => $program->id,
            'purpose' => 'Accreditation Preparation',
            'status' => 'active',
            'created_by' => Auth::id()
        ]);

        // 2. Create Accreditation
        $accreditation = Accreditation::create([
            'program_id' => $program->id,
            'task_force_id' => $taskForce->id,
            'status' => 'scheduled',
            'target_date' => $this->target_date,
            'created_by' => Auth::id()
        ]);

        // 3. Audit Log
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'Scheduled new accreditation for ' . $program->name,
            'target_type' => 'Accreditation',
            'target_id' => $accreditation->id,
            'timestamp' => now()
        ]);

        // 4. Notify the Dean (College Head)
        $deanRole = Role::where('role_name', 'college-head')->first();
        if ($deanRole) {
            $dean = User::where('college_id', $program->college_id)
                ->where('role_id', $deanRole->id)
                ->first();

            if ($dean) {
                Notification::create([
                    'user_id' => $dean->id,
                    'type' => 'accreditation_scheduled',
                    'message' => 'Accreditation scheduled for ' . $program->name . '. Action Required: Setup Task Force.',
                    'is_read' => false
                ]);
            }
        }

        $this->reset(['program_id', 'target_date', 'showModal']);
        
        // Let the frontend know we updated
        $this->dispatch('accreditation-scheduled');
    }

    public function render()
    {
        $programs = Program::with('college')->orderBy('college_id')->get();
        return view('livewire.monitoring.schedule-accreditation', compact('programs'));
    }
}
