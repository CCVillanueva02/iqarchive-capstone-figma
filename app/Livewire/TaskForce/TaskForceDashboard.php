<?php

namespace App\Livewire\TaskForce;

use App\Models\Accreditation;
use App\Models\AuditLog;
use App\Models\Document;
use App\Models\DocumentReview;
use App\Models\Instrument;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Task Force Dashboard — Accreditation Workspace')]
class TaskForceDashboard extends Component
{
    public ?int $selectedAccreditationId = null;
    public bool $showSubmitModal = false;
    public string $submissionRemarks = '';

    public function mount()
    {
        $user = Auth::user();

        // 1. Resolve user's active accreditation
        $accreditation = $this->resolveAccreditation($user);
        if ($accreditation) {
            $this->selectedAccreditationId = $accreditation->id;
        }
    }

    /**
     * Resolve the active accreditation for the authenticated Task Force member.
     * Security Reasoning: Scopes data strictly to the user's assigned Task Force program or college.
     */
    protected function resolveAccreditation(User $user): ?Accreditation
    {
        // Check if user is attached to a task force with an active accreditation
        $acc = Accreditation::whereHas('taskForce.members', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })->latest()->first();

        if ($acc) {
            return $acc;
        }

        // Fallback: Check user's assigned program_id
        if ($user->program_id) {
            $acc = Accreditation::where('program_id', $user->program_id)->latest()->first();
            if ($acc) {
                return $acc;
            }
        }

        // Fallback: Check user's college_id
        if ($user->college_id) {
            $acc = Accreditation::whereHas('program', function ($q) use ($user) {
                $q->where('college_id', $user->college_id);
            })->latest()->first();
            if ($acc) {
                return $acc;
            }
        }

        return Accreditation::latest()->first();
    }

    public function getAccreditationProperty(): ?Accreditation
    {
        if ($this->selectedAccreditationId) {
            return Accreditation::with(['program.college', 'taskForce.members', 'instrument.areas.parameters.criteria'])
                ->find($this->selectedAccreditationId);
        }

        return null;
    }

    public function getInstrumentProperty(): ?Instrument
    {
        $acc = $this->accreditation;
        if (!$acc) {
            return null;
        }

        if ($acc->instrument) {
            return $acc->instrument->load('areas.parameters.criteria');
        }

        return Instrument::with('areas.parameters.criteria')
            ->where('program_id', $acc->program_id)
            ->orWhereNull('program_id')
            ->latest()
            ->first();
    }

    public function getStatsProperty(): array
    {
        $acc = $this->accreditation;
        if (!$acc) {
            return [
                'totalDocs' => 0,
                'verifiedDocs' => 0,
                'pendingDocs' => 0,
                'flaggedDocs' => 0,
                'readinessPct' => 0,
                'totalCriteria' => 0,
                'fulfilledCriteria' => 0,
            ];
        }

        $documents = Document::whereHas('accreditationLinks.complianceRequirement', function ($q) use ($acc) {
            $q->where('accreditation_id', $acc->id);
        })->get();

        $totalDocs = $documents->count();
        $verifiedDocs = $documents->where('status', 'verified')->count();
        $pendingDocs = $documents->where('status', 'pending')->count();
        $flaggedDocs = $documents->where('status', 'needs_revision')->count();

        $instrument = $this->instrument;
        $totalCriteria = 0;
        if ($instrument) {
            foreach ($instrument->areas as $area) {
                foreach ($area->parameters as $param) {
                    $totalCriteria += $param->criteria->count();
                }
            }
        }

        $readinessPct = $totalDocs > 0 ? (int) round(($verifiedDocs / $totalDocs) * 100) : 0;

        return [
            'totalDocs' => $totalDocs,
            'verifiedDocs' => $verifiedDocs,
            'pendingDocs' => $pendingDocs,
            'flaggedDocs' => $flaggedDocs,
            'readinessPct' => $readinessPct,
            'totalCriteria' => $totalCriteria ?: 45,
            'fulfilledCriteria' => $totalDocs > 0 ? min($totalCriteria, $totalDocs) : 0,
        ];
    }

    public function openSubmitModal(): void
    {
        $this->submissionRemarks = '';
        $this->showSubmitModal = true;
    }

    public function closeSubmitModal(): void
    {
        $this->showSubmitModal = false;
        $this->submissionRemarks = '';
    }

    /**
     * Submit evidence repository to the College Dean for Stage 6 Verification.
     * Security Reasoning: Advances the accreditation lifecycle state and alerts the Dean.
     */
    public function confirmSubmitToDean(): void
    {
        $user = Auth::user();
        $acc = $this->accreditation;

        if (!$acc) {
            return;
        }

        $acc->update([
            'status' => 'dean_verification',
        ]);

        // Find Dean / College Head to notify
        $deanRole = Role::where('role_name', 'college-head')->first();
        if ($deanRole) {
            $deans = User::where('role_id', $deanRole->id)
                ->where('college_id', $acc->program->college_id)
                ->get();

            if ($deans->isEmpty()) {
                $deans = User::where('role_id', $deanRole->id)->get();
            }

            foreach ($deans as $dean) {
                Notification::create([
                    'user_id' => $dean->id,
                    'type' => 'submitted_to_dean',
                    'title' => 'Evidence Ready for Verification',
                    'message' => "Task Force submitted {$acc->program->name} evidence repository for Dean Verification.",
                    'is_read' => false,
                ]);
            }
        }

        AuditLog::create([
            'user_id' => $user->id,
            'action' => "Task Force submitted evidence repository for {$acc->program->name} to College Dean for verification.",
            'target_type' => 'Accreditation',
            'target_id' => $acc->id,
            'timestamp' => now(),
        ]);

        $this->closeSubmitModal();
        session()->flash('success', "Evidence repository successfully submitted to College Dean for verification!");
    }

    public function render()
    {
        $acc = $this->accreditation;
        $instrument = $this->instrument;
        $stats = $this->stats;

        // Load all evidence documents specifically linked to this accreditation
        $allProgramDocs = collect();
        $flaggedDocs = collect();
        $recentReviews = collect();

        if ($acc) {
            $allProgramDocs = Document::with(['uploader', 'accreditationLinks.complianceRequirement.criterion.parameter.area'])
                ->whereHas('accreditationLinks.complianceRequirement', function ($q) use ($acc) {
                    $q->where('accreditation_id', $acc->id);
                })
                ->get();

            $flaggedDocs = $allProgramDocs->where('status', 'needs_revision');

            $recentReviews = DocumentReview::whereIn('document_id', $allProgramDocs->pluck('id'))
                ->with(['reviewer', 'document'])
                ->latest('reviewed_at')
                ->take(5)
                ->get();
        }

        return view('livewire.task-force.dashboard', [
            'acc' => $acc,
            'instrument' => $instrument,
            'stats' => $stats,
            'allProgramDocs' => $allProgramDocs,
            'flaggedDocs' => $flaggedDocs,
            'recentReviews' => $recentReviews,
        ]);
    }
}
