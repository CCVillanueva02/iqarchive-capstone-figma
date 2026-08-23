<?php

namespace App\Livewire\CollegeHead;

use App\Models\Accreditation;
use App\Models\AuditLog;
use App\Models\College;
use App\Models\Notification;
use App\Models\Program;
use App\Models\Role;
use App\Models\TaskForce;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dean Dashboard — College QA')]
class Dashboard extends Component
{
    public $searchProgram = '';
    public $statusFilter = 'all';

    public $selectedAccreditationId = null;
    public $selectedProgramId = null;
    public $showProposeModal = false;
    public $showTimelineModal = false;
    public $showHistoryModal = false;

    // Task Force Nomination Form State
    public $newName = '';
    public $newEmail = '';
    public $newRole = 'Area Chair';
    public $newPhone = '';
    public $proposedMembers = [];

    protected $listeners = [
        'proposal-submitted' => '$refresh',
        'accreditation-updated' => '$refresh',
    ];

    /**
     * Retrieve the active college scoped for the Dean / College Head.
     * 
     * Security Reasoning: Queries are strictly constrained by the authenticated user's
     * assigned college_id to enforce multi-tenant college data isolation and prevent unauthorized cross-college data access.
     */
    public function getCollegeProperty()
    {
        $user = Auth::user();
        if ($user && $user->college_id) {
            return College::find($user->college_id);
        }

        // Fallback for System Administrator / preview mode
        return College::first();
    }

    /**
     * Compute high-level KPI cards for the Dean's college.
     */
    public function getKpiMetricsProperty()
    {
        $college = $this->college;
        if (! $college) {
            return [
                'totalPrograms' => 0,
                'accreditedPrograms' => 0,
                'activeVisits' => 0,
                'activeTaskForces' => 0,
                'pendingActions' => 0,
                'pendingProposals' => 0,
                'pendingVerifications' => 0,
                'accreditationRate' => 0,
            ];
        }

        $programs = Program::where('college_id', $college->id)->get();
        $totalPrograms = $programs->count();

        $accreditedCount = $programs->filter(function ($p) {
            $lvl = strtolower($p->accreditation_level ?? '');
            return str_contains($lvl, 'level') || str_contains($lvl, 'accredited');
        })->count();

        $activeVisits = Accreditation::whereHas('program', function ($q) use ($college) {
            $q->where('college_id', $college->id);
        })->whereNotIn('status', ['completed', 'cancelled'])->count();

        $activeTaskForces = TaskForce::where('college_id', $college->id)
            ->where('status', 'active')
            ->count();

        $pendingProposals = Accreditation::whereHas('program', function ($q) use ($college) {
            $q->where('college_id', $college->id);
        })->where('status', 'scheduled')->count();

        $pendingVerifications = Accreditation::whereHas('program', function ($q) use ($college) {
            $q->where('college_id', $college->id);
        })->where('status', 'dean_verification')->count();

        $accreditationRate = $totalPrograms > 0 ? round(($accreditedCount / $totalPrograms) * 100) : 0;

        return [
            'totalPrograms' => $totalPrograms,
            'accreditedPrograms' => $accreditedCount,
            'activeVisits' => $activeVisits,
            'activeTaskForces' => $activeTaskForces,
            'pendingActions' => $pendingProposals + $pendingVerifications,
            'pendingProposals' => $pendingProposals,
            'pendingVerifications' => $pendingVerifications,
            'accreditationRate' => $accreditationRate,
        ];
    }

    /**
     * Accreditations waiting for Task Force nomination by the Dean.
     */
    public function getPendingSetupAccreditationsProperty()
    {
        $college = $this->college;
        if (! $college) {
            return collect();
        }

        return Accreditation::with(['program', 'creator'])
            ->whereHas('program', function ($q) use ($college) {
                $q->where('college_id', $college->id);
            })
            ->where('status', 'scheduled')
            ->latest()
            ->get();
    }

    /**
     * Accreditations waiting for Stage 6 Two-Stage Dean Verification.
     */
    public function getPendingVerificationAccreditationsProperty()
    {
        $college = $this->college;
        if (! $college) {
            return collect();
        }

        return Accreditation::with(['program', 'taskForce'])
            ->whereHas('program', function ($q) use ($college) {
                $q->where('college_id', $college->id);
            })
            ->where('status', 'dean_verification')
            ->latest()
            ->get();
    }

    /**
     * Table 1: ONLY programs that have an active / current accreditation in progress.
     */
    public function getActiveAccreditationProgramsProperty()
    {
        $college = $this->college;
        if (! $college) {
            return collect();
        }

        return Program::with(['college', 'accreditations' => function ($q) {
            $q->whereNotIn('status', ['completed', 'cancelled'])->latest();
        }, 'accreditations.taskForce'])
            ->where('college_id', $college->id)
            ->whereHas('accreditations', function ($q) {
                $q->whereNotIn('status', ['completed', 'cancelled']);
            })
            ->when(! empty($this->searchProgram), function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->searchProgram . '%')
                        ->orWhere('code', 'like', '%' . $this->searchProgram . '%');
                });
            })
            ->orderBy('name')
            ->get();
    }

    /**
     * Table 2: Complete College Degree Programs Directory with Validity & Status (Same as Monitoring).
     */
    public function getAllCollegeProgramsProperty()
    {
        $college = $this->college;
        if (! $college) {
            return collect();
        }

        return Program::with(['college'])
            ->where('college_id', $college->id)
            ->when(! empty($this->searchProgram), function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->searchProgram . '%')
                        ->orWhere('code', 'like', '%' . $this->searchProgram . '%');
                });
            })
            ->orderBy('name')
            ->get();
    }

    public function getSelectedProgramProperty()
    {
        if (! $this->selectedProgramId) {
            return null;
        }

        return Program::with(['college', 'accreditations'])->find($this->selectedProgramId);
    }

    public function viewProgramHistory($programId)
    {
        $this->selectedProgramId = $programId;
        $this->showHistoryModal = true;
    }

    public function closeHistoryModal()
    {
        $this->showHistoryModal = false;
        $this->selectedProgramId = null;
    }

    /**
     * Selected accreditation record for modals.
     */
    public function getSelectedAccreditationProperty()
    {
        if (! $this->selectedAccreditationId) {
            return null;
        }

        return Accreditation::with(['program.college', 'taskForce', 'creator'])
            ->find($this->selectedAccreditationId);
    }

    /**
     * Strictly evaluate the 7-stage lifecycle progression for the timeline modal.
     */
    public function getTimelineStagesProperty()
    {
        $acc = $this->selectedAccreditation;
        if (! $acc) {
            return [];
        }

        $currentStatus = $acc->status ?? 'scheduled';
        $isCancelled = $currentStatus === 'cancelled';
        $hasProposedMembers = ! empty($acc->proposed_members);
        $hasAssignedTaskForce = (bool) $acc->task_force_id && ($acc->taskForce?->status === 'active');

        $statusRanks = [
            'scheduled' => 1,
            'pending_task_force' => 1,
            'task_force_setup' => 2,
            'task_force_approved' => 3,
            'instrument_building' => 4,
            'document_preparation' => 5,
            'uploading' => 5,
            'dean_verification' => 6,
            'submitted' => 7,
            'completed' => 7,
            'cancelled' => 0,
        ];

        $currentRank = $statusRanks[$currentStatus] ?? 1;

        // Stage 1
        $stage1Status = 'completed';
        $stage1Meta = 'Initiated by ' . ($acc->creator?->name ?? 'IQA Staff');

        // Stage 2
        $stage2Status = 'pending';
        $stage2Meta = 'Awaiting Dean nomination';
        if ($isCancelled) {
            $stage2Status = 'cancelled';
            $stage2Meta = 'Cancelled';
        } elseif ($currentRank >= 2 || $hasProposedMembers) {
            $stage2Status = 'completed';
            $count = is_array($acc->proposed_members) ? count($acc->proposed_members) : 0;
            $stage2Meta = $count > 0 ? "Nominated {$count} faculty members" : 'Nomination submitted by Dean';
        } else {
            $stage2Status = 'in_progress';
            $stage2Meta = 'Awaiting Dean nomination';
        }

        // Stage 3 (Strictly gated by Stage 2)
        $stage3Status = 'pending';
        $stage3Meta = 'Awaiting Task Force nomination';
        if ($isCancelled) {
            $stage3Status = 'cancelled';
            $stage3Meta = 'Cancelled';
        } elseif ($stage2Status === 'completed') {
            if ($currentRank >= 3 || $hasAssignedTaskForce) {
                $stage3Status = 'completed';
                $stage3Meta = $acc->taskForce ? ('Roster assigned: ' . $acc->taskForce->name) : 'Roster officially assigned';
            } elseif ($currentRank === 2 || $hasProposedMembers) {
                $stage3Status = 'in_progress';
                $stage3Meta = 'Pending IQA roster review & assignment';
            }
        }

        // Stage 4 (Strictly gated by Stage 3)
        $stage4Status = 'pending';
        $stage4Meta = 'Pending previous stages';
        if ($isCancelled) {
            $stage4Status = 'cancelled';
            $stage4Meta = 'Cancelled';
        } elseif ($stage3Status === 'completed') {
            if ($currentRank > 4) {
                $stage4Status = 'completed';
                $stage4Meta = 'Template configured';
            } elseif ($currentRank === 4 || $currentRank === 3) {
                $stage4Status = 'in_progress';
                $stage4Meta = 'Template tailoring active';
            }
        }

        // Stage 5 (Strictly gated by Stage 4)
        $stage5Status = 'pending';
        $stage5Meta = 'Locked';
        if ($isCancelled) {
            $stage5Status = 'cancelled';
            $stage5Meta = 'Cancelled';
        } elseif ($stage4Status === 'completed') {
            if ($currentRank > 5) {
                $stage5Status = 'completed';
                $stage5Meta = 'Evidence submitted';
            } elseif ($currentRank === 5) {
                $stage5Status = 'in_progress';
                $stage5Meta = 'Evidence repository open for uploads';
            }
        }

        // Stage 6 (Strictly gated by Stage 5)
        $stage6Status = 'pending';
        $stage6Meta = 'Awaiting evidence submission';
        if ($isCancelled) {
            $stage6Status = 'cancelled';
            $stage6Meta = 'Cancelled';
        } elseif ($stage5Status === 'completed') {
            if ($currentRank > 6) {
                $stage6Status = 'completed';
                $stage6Meta = 'Verified by College Dean';
            } elseif ($currentRank === 6) {
                $stage6Status = 'in_progress';
                $stage6Meta = 'Dean verification active';
            }
        }

        // Stage 7 (Strictly gated by Stage 6)
        $stage7Status = 'pending';
        $stage7Meta = 'Awaiting final handover';
        if ($isCancelled) {
            $stage7Status = 'cancelled';
            $stage7Meta = 'Cancelled';
        } elseif ($stage6Status === 'completed') {
            if ($currentRank >= 7) {
                $stage7Status = ($currentStatus === 'completed') ? 'completed' : 'in_progress';
                $stage7Meta = ($currentStatus === 'completed') ? 'Accreditation cycle completed' : 'Under review by IQA & Board';
            }
        }

        return [
            [
                'step' => 1,
                'title' => 'Accreditation Initiation & Scheduling',
                'actor' => 'IQA Office',
                'actor_badge' => 'iqa',
                'description' => 'Accreditation visit recorded with target date. Notification dispatched to College Dean.',
                'status' => $stage1Status,
                'timestamp' => $acc->created_at ? $acc->created_at->format('M d, Y · h:i A') : null,
                'meta' => $stage1Meta,
            ],
            [
                'step' => 2,
                'title' => 'Task Force Nomination',
                'actor' => 'College Dean',
                'actor_badge' => 'dean',
                'description' => 'College Dean nominates faculty members for the Program Accreditation Task Force.',
                'status' => $stage2Status,
                'timestamp' => ($stage2Status === 'completed' && $acc->updated_at) ? $acc->updated_at->format('M d, Y · h:i A') : null,
                'meta' => $stage2Meta,
            ],
            [
                'step' => 3,
                'title' => 'Task Force Official Assignment',
                'actor' => 'IQA Office',
                'actor_badge' => 'iqa',
                'description' => 'IQA reviews and formalizes the roster with the Dean assigned as Task Force Lead.',
                'status' => $stage3Status,
                'timestamp' => ($stage3Status === 'completed' && $acc->taskForce?->updated_at) ? $acc->taskForce->updated_at->format('M d, Y · h:i A') : null,
                'meta' => $stage3Meta,
            ],
            [
                'step' => 4,
                'title' => 'Instrument Template Customization',
                'actor' => 'Dean & Task Force',
                'actor_badge' => 'dean',
                'description' => 'AACCUP instrument template is tailored in the UI Builder with program-specific parameters.',
                'status' => $stage4Status,
                'timestamp' => null,
                'meta' => $stage4Meta,
            ],
            [
                'step' => 5,
                'title' => 'Document Upload & Evidence Gathering',
                'actor' => 'Task Force Members',
                'actor_badge' => 'task_force',
                'description' => 'Assigned Task Force members upload required artifacts and compliance proofs to the area repository.',
                'status' => $stage5Status,
                'timestamp' => null,
                'meta' => $stage5Meta,
            ],
            [
                'step' => 6,
                'title' => 'Two-Stage Dean Verification',
                'actor' => 'College Dean',
                'actor_badge' => 'dean',
                'description' => 'Two-tier validation: Stage 1 error checking followed by Stage 2 completeness review.',
                'status' => $stage6Status,
                'timestamp' => null,
                'meta' => $stage6Meta,
            ],
            [
                'step' => 7,
                'title' => 'Accreditation Submission & Review',
                'actor' => 'IQA & Accreditors',
                'actor_badge' => 'iqa',
                'description' => 'Final accredited package handed over to IQA Office for official technical review and board action.',
                'status' => $stage7Status,
                'timestamp' => null,
                'meta' => $stage7Meta,
            ],
        ];
    }

    public function openProposeModal($accreditationId)
    {
        $this->selectedAccreditationId = $accreditationId;
        $this->proposedMembers = [];
        $this->reset(['newName', 'newEmail', 'newPhone', 'newRole']);
        $this->newRole = 'Area Chair';
        $this->showProposeModal = true;
    }

    public function closeProposeModal()
    {
        $this->showProposeModal = false;
        $this->reset(['selectedAccreditationId', 'proposedMembers', 'newName', 'newEmail', 'newPhone', 'newRole']);
    }

    public function addMember()
    {
        $this->validate([
            'newName' => 'required|string|max:255',
            'newEmail' => 'required|email|max:255',
            'newRole' => 'required|string|max:100',
            'newPhone' => 'nullable|string|max:30',
        ], [
            'newName.required' => 'Faculty member full name is required.',
            'newEmail.required' => 'A valid institutional email is required.',
            'newEmail.email' => 'Please provide a valid email format.',
            'newRole.required' => 'Designation role is required.',
        ]);

        $this->proposedMembers[] = [
            'name' => trim($this->newName),
            'email' => trim($this->newEmail),
            'role' => trim($this->newRole),
            'phone' => trim($this->newPhone),
        ];

        $this->reset(['newName', 'newEmail', 'newPhone']);
        $this->newRole = 'Area Chair';
    }

    public function removeMember($index)
    {
        if (isset($this->proposedMembers[$index])) {
            unset($this->proposedMembers[$index]);
            $this->proposedMembers = array_values($this->proposedMembers);
        }
    }

    /**
     * Submit proposed Task Force members to IQA for review and formalization.
     * 
     * Security Reasoning: College Deans have institutional authority over college faculty
     * rosters to nominate task force members while IQA retains central verification and approval authority.
     */
    public function submitProposal()
    {
        $user = Auth::user();
        if (! $this->selectedAccreditationId || empty($this->proposedMembers)) {
            return;
        }

        $accreditation = Accreditation::with('program.college')->findOrFail($this->selectedAccreditationId);

        // Authorization check: Must be for the user's assigned college
        if ($user->college_id && $accreditation->program->college_id !== $user->college_id) {
            abort(403, 'Unauthorized to nominate task force for another college.');
        }

        $accreditation->proposed_members = $this->proposedMembers;
        $accreditation->status = 'task_force_setup';
        $accreditation->save();

        // Audit Log
        AuditLog::create([
            'user_id' => $user->id,
            'action' => "Submitted Task Force nomination (" . count($this->proposedMembers) . " members) for {$accreditation->program->name}",
            'target_type' => 'Accreditation',
            'target_id' => $accreditation->id,
            'timestamp' => now(),
        ]);

        // Notify IQA Staff
        $iqaRole = Role::whereIn('role_name', ['iqa-staff', 'system-administrator'])->pluck('id');
        $iqaUsers = User::whereIn('role_id', $iqaRole)->get();
        foreach ($iqaUsers as $iqa) {
            Notification::create([
                'user_id' => $iqa->id,
                'type' => 'task_force_proposed',
                'message' => "Dean submitted Task Force nomination for {$accreditation->program->name}.",
                'is_read' => false,
            ]);
        }

        $this->closeProposeModal();
        session()->flash('status', "Task force nomination submitted successfully for {$accreditation->program->name}. Awaiting IQA roster review.");
        $this->dispatch('proposal-submitted');
    }

    public function openTimeline($accreditationId)
    {
        $this->selectedAccreditationId = $accreditationId;
        $this->showTimelineModal = true;
    }

    public function closeTimeline()
    {
        $this->showTimelineModal = false;
        $this->selectedAccreditationId = null;
    }

    public function render()
    {
        return view('livewire.college-head.dashboard', [
            'college' => $this->college,
            'kpiMetrics' => $this->kpiMetrics,
            'pendingSetupAccreditations' => $this->pendingSetupAccreditations,
            'pendingVerificationAccreditations' => $this->pendingVerificationAccreditations,
            'activeAccreditationPrograms' => $this->activeAccreditationPrograms,
            'allCollegePrograms' => $this->allCollegePrograms,
            'selectedProgram' => $this->selectedProgram,
            'selectedAccreditation' => $this->selectedAccreditation,
            'timelineStages' => $this->timelineStages,
        ]);
    }
}
