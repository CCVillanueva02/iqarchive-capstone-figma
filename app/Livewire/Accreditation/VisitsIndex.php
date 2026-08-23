<?php

namespace App\Livewire\Accreditation;

use App\Models\Accreditation;
use App\Models\AuditLog;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

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
        $hasTaskForce = (bool) $acc->task_force_id;
        $isTfActive = $hasTaskForce && ($acc->taskForce?->status === 'active');

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
                'status' => $isCancelled ? 'cancelled' : ($hasTaskForce ? 'completed' : ($currentRank === 1 ? 'in_progress' : 'pending')),
                'timestamp' => $acc->taskForce?->created_at ? $acc->taskForce->created_at->format('M d, Y · h:i A') : null,
                'meta' => $hasTaskForce ? ('Task Force: ' . $acc->taskForce->name) : ($isCancelled ? 'Cancelled' : 'Awaiting nomination'),
            ],
            [
                'step' => 3,
                'title' => 'Task Force Official Assignment',
                'actor' => 'IQA Office',
                'actor_badge' => 'iqa',
                'description' => 'IQA reviews and formalizes the roster with the Dean assigned as Task Force Lead.',
                'status' => $isCancelled ? 'cancelled' : ($isTfActive ? 'completed' : ($hasTaskForce && ! $isTfActive ? 'in_progress' : ($currentRank >= 3 ? 'completed' : 'pending'))),
                'timestamp' => $isTfActive ? $acc->taskForce->updated_at->format('M d, Y · h:i A') : null,
                'meta' => $isTfActive ? 'Roster officially assigned' : ($isCancelled ? 'Cancelled' : 'Pending IQA verification'),
            ],
            [
                'step' => 4,
                'title' => 'Instrument Template Customization',
                'actor' => 'Dean & Task Force',
                'actor_badge' => 'dean',
                'description' => 'AACCUP instrument template is tailored in the UI Builder with program-specific parameters.',
                'status' => $isCancelled ? 'cancelled' : ($currentRank > 4 ? 'completed' : ($currentRank === 4 ? 'in_progress' : 'pending')),
                'timestamp' => null,
                'meta' => $currentRank >= 4 ? 'Template configured' : ($isCancelled ? 'Cancelled' : 'Pending previous stages'),
            ],
            [
                'step' => 5,
                'title' => 'Document Upload & Evidence Gathering',
                'actor' => 'Task Force Members',
                'actor_badge' => 'task_force',
                'description' => 'Assigned Task Force members upload required artifacts and compliance proofs to the area repository.',
                'status' => $isCancelled ? 'cancelled' : ($currentRank > 5 ? 'completed' : ($currentRank === 5 ? 'in_progress' : 'pending')),
                'timestamp' => null,
                'meta' => $currentRank >= 5 ? 'Evidence repository unlocked' : ($isCancelled ? 'Cancelled' : 'Locked'),
            ],
            [
                'step' => 6,
                'title' => 'Two-Stage Dean Verification',
                'actor' => 'College Dean',
                'actor_badge' => 'dean',
                'description' => 'Two-tier validation: Stage 1 error checking followed by Stage 2 completeness review.',
                'status' => $isCancelled ? 'cancelled' : ($currentRank > 6 ? 'completed' : ($currentRank === 6 ? 'in_progress' : 'pending')),
                'timestamp' => null,
                'meta' => $currentRank >= 6 ? 'Verification active' : ($isCancelled ? 'Cancelled' : 'Awaiting evidence submission'),
            ],
            [
                'step' => 7,
                'title' => 'Accreditation Submission & Review',
                'actor' => 'IQA & Accreditors',
                'actor_badge' => 'iqa',
                'description' => 'Final accredited package handed over to IQA Office for official technical review and board action.',
                'status' => $isCancelled ? 'cancelled' : ($currentRank >= 7 ? 'completed' : 'pending'),
                'timestamp' => null,
                'meta' => $currentRank >= 7 ? 'Submitted to IQA' : ($isCancelled ? 'Cancelled' : 'Awaiting final handover'),
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
        ])->title('Accreditation Visits');
    }
}
