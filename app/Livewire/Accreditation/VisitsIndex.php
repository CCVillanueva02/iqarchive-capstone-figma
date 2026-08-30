<?php

namespace App\Livewire\Accreditation;

use App\Models\Accreditation;
use App\Models\AuditLog;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Accreditation Visits')]
class VisitsIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';

    public $selectedAccreditationId = null;
    public $showTimelineModal = false;

    protected $listeners = ['accreditation-scheduled' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function openTimeline($id)
    {
        $this->selectedAccreditationId = $id;
        $this->showTimelineModal = true;
    }

    public function closeTimeline()
    {
        $this->selectedAccreditationId = null;
        $this->showTimelineModal = false;
    }

    /**
     * Cancel an initiated accreditation visit.
     * 
     * Security Reasoning: Only IQA Staff, IQA Admin, and System Administrator
     * roles are permitted to cancel an active accreditation visit to prevent
     * unauthorized cancellation of compliance workflows and university surveys.
     */
    public function cancelAccreditation($id)
    {
        $user = Auth::user();
        if (! $user || ! in_array($user->role, ['iqa-staff', 'iqa-admin', 'system-administrator'])) {
            abort(403, 'Unauthorized to cancel accreditation visit.');
        }

        $accreditation = Accreditation::with(['program.college', 'taskForce'])->findOrFail($id);

        if ($accreditation->status === 'cancelled') {
            $this->dispatch('swal', [
                'icon' => 'info',
                'title' => 'Already Cancelled',
                'text' => 'This accreditation visit is already cancelled.'
            ]);
            return;
        }

        // 1. Update status to cancelled
        $accreditation->update(['status' => 'cancelled']);

        // 2. Cancel associated pending task force if exists
        if ($accreditation->taskForce && in_array($accreditation->taskForce->status, ['pending_approval', 'active'])) {
            $accreditation->taskForce->update(['status' => 'cancelled']);
        }

        // 3. Write to AuditLog (Audit trail enforcement)
        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'Cancelled accreditation visit for ' . ($accreditation->program->name ?? 'Program'),
            'target_type' => 'Accreditation',
            'target_id' => $accreditation->id,
            'timestamp' => now(),
        ]);

        // 4. Notify the College Dean
        $deanRole = Role::where('role_name', 'college-head')->first();
        if ($deanRole && $accreditation->program) {
            $dean = User::where('college_id', $accreditation->program->college_id)
                ->where('role_id', $deanRole->id)
                ->first();

            if ($dean) {
                Notification::create([
                    'user_id' => $dean->id,
                    'type' => 'accreditation_cancelled',
                    'message' => 'Accreditation visit for ' . $accreditation->program->name . ' has been cancelled by the IQA Office.',
                    'is_read' => false,
                ]);
            }
        }

        $this->closeTimeline();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Accreditation Cancelled',
            'text' => 'The accreditation visit for ' . ($accreditation->program->name ?? 'the program') . ' has been cancelled.'
        ]);
    }

    public function getSelectedAccreditationProperty()
    {
        if (! $this->selectedAccreditationId) {
            return null;
        }

        return Accreditation::with([
            'program.college',
            'taskForce.members',
            'creator',
        ])->find($this->selectedAccreditationId);
    }

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

        // STAGE 1: Always completed once visit is initialized
        $stage1Status = 'completed';
        $stage1Meta = 'Initiated by ' . ($acc->creator?->name ?? 'IQA Staff');

        // STAGE 2: Task Force Nomination (Dean)
        // Can ONLY be completed if stage 1 is completed AND ($currentRank >= 2 || $hasProposedMembers)
        // If stage 1 is completed but stage 2 is NOT completed -> stage 2 is in_progress
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

        // STAGE 3: Task Force Official Assignment (IQA)
        // Can ONLY be active or completed IF STAGE 2 IS COMPLETED!
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

        // STAGE 4: Instrument Template Customization (Dean & Task Force)
        // Can ONLY be active or completed IF STAGE 3 IS COMPLETED!
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

        // STAGE 5: Document Upload & Evidence Gathering (Task Force Members)
        // Can ONLY be active or completed IF STAGE 4 IS COMPLETED!
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

        // STAGE 6: Two-Stage Dean Verification (College Dean)
        // Can ONLY be active or completed IF STAGE 5 IS COMPLETED!
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

        // STAGE 7: Accreditation Submission & Review (IQA & Accreditors)
        // Can ONLY be active or completed IF STAGE 6 IS COMPLETED!
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
                'status' => 'completed',
                'timestamp' => $acc->created_at ? $acc->created_at->format('M d, Y · h:i A') : null,
                'meta' => 'Initiated by ' . ($acc->creator?->name ?? 'IQA Staff'),
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

    public function render()
    {
        $user = Auth::user();

        $baseQuery = Accreditation::with(['program.college', 'taskForce.members', 'creator']);

        if ($user && $user->role === 'college-head') {
            $baseQuery->whereHas('program', function ($q) use ($user) {
                $q->where('college_id', $user->college_id);
            });
        } elseif (! $user || ! in_array($user->role, ['iqa-staff', 'iqa-admin', 'system-administrator', 'university-administrator', 'college-head'])) {
            $baseQuery->where('id', 0);
        }

        // Calculate KPI Stats
        $statsQuery = clone $baseQuery;
        $allAccreditationItems = $statsQuery->get();

        $totalVisits = $allAccreditationItems->where('status', '!=', 'cancelled')->count();
        $scheduledCount = $allAccreditationItems->whereIn('status', ['scheduled', 'pending_task_force'])->count();
        $inProgressCount = $allAccreditationItems->whereIn('status', ['task_force_setup', 'task_force_approved', 'instrument_building', 'document_preparation', 'uploading', 'dean_verification'])->count();
        $completedCount = $allAccreditationItems->whereIn('status', ['submitted', 'completed'])->count();

        // Apply Search & Status Filters for Table
        $query = clone $baseQuery;

        if (! empty($this->search)) {
            $term = '%' . $this->search . '%';
            $query->where(function ($q) use ($term) {
                $q->whereHas('program', function ($sub) use ($term) {
                    $sub->where('name', 'like', $term)
                        ->orWhere('code', 'like', $term)
                        ->orWhereHas('college', function ($c) use ($term) {
                            $c->where('name', 'like', $term)
                              ->orWhere('code', 'like', $term);
                        });
                });
            });
        }

        if ($this->statusFilter !== 'all') {
            if ($this->statusFilter === 'scheduled') {
                $query->whereIn('status', ['scheduled', 'pending_task_force']);
            } elseif ($this->statusFilter === 'in_progress') {
                $query->whereIn('status', ['task_force_setup', 'task_force_approved', 'instrument_building', 'document_preparation', 'uploading', 'dean_verification']);
            } elseif ($this->statusFilter === 'completed') {
                $query->whereIn('status', ['submitted', 'completed']);
            } elseif ($this->statusFilter === 'cancelled') {
                $query->where('status', 'cancelled');
            }
        }

        $accreditations = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.accreditation.visits-index', [
            'accreditations' => $accreditations,
            'totalVisits' => $totalVisits,
            'scheduledCount' => $scheduledCount,
            'inProgressCount' => $inProgressCount,
            'completedCount' => $completedCount,
            'selectedAccreditation' => $this->selectedAccreditation,
            'timelineStages' => $this->timelineStages,
        ]);
    }
}
