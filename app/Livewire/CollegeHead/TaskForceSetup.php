<?php

namespace App\Livewire\CollegeHead;

use App\Models\Accreditation;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TaskForceSetup extends Component
{
    public $selectedAccreditationId = null;

    public $proposedMembers = []; // Will now hold arrays of ['name', 'email', 'phone']

    public $newName = '';

    public $newEmail = '';

    public $newPhone = '';

    public function selectAccreditation($id)
    {
        $this->selectedAccreditationId = $id;
        $this->proposedMembers = [];
        $this->reset(['newName', 'newEmail', 'newPhone']);
    }

    public function addMember()
    {
        $this->validate([
            'newName' => 'required|string|max:255',
            'newEmail' => 'required|email|max:255',
            'newPhone' => 'required|string|max:20',
        ]);

        $this->proposedMembers[] = [
            'name' => $this->newName,
            'email' => $this->newEmail,
            'phone' => $this->newPhone,
        ];

        $this->reset(['newName', 'newEmail', 'newPhone']);
    }

    public function removeMember($index)
    {
        if (isset($this->proposedMembers[$index])) {
            unset($this->proposedMembers[$index]);
            $this->proposedMembers = array_values($this->proposedMembers); // re-index
        }
    }

    public function submitProposal()
    {
        if (! $this->selectedAccreditationId || empty($this->proposedMembers)) {
            return;
        }

        $accreditation = Accreditation::findOrFail($this->selectedAccreditationId);

        // Save the proposed members array directly
        $accreditation->proposed_members = $this->proposedMembers;
        $accreditation->status = 'task_force_setup'; // move to next step for IQA review
        $accreditation->save();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'Submitted Task Force proposal for '.$accreditation->program->name,
            'target_type' => 'Accreditation',
            'target_id' => $accreditation->id,
            'timestamp' => now(),
        ]);

        $this->reset(['selectedAccreditationId', 'proposedMembers']);
        $this->dispatch('proposal-submitted');
    }

    public function render()
    {
        $user = Auth::user();

        // Get accreditations waiting for Task Force setup for this Dean's college
        $pendingAccreditations = Accreditation::with('program')
            ->where('status', 'scheduled')
            ->whereHas('program', function ($query) use ($user) {
                $query->where('college_id', $user->college_id);
            })
            ->get();

        return view('livewire.college-head.task-force-setup', compact('pendingAccreditations'));
    }
}
