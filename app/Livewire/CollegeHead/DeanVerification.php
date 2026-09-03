<?php

namespace App\Livewire\CollegeHead;

use App\Models\Accreditation;
use App\Models\AuditLog;
use App\Models\Document;
use App\Models\DocumentReview;
use App\Models\Instrument;
use App\Models\InstrumentArea;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dean Verification & Quality Review')]
#[Layout('layouts.app')]
class DeanVerification extends Component
{
    public int $accreditationId;

    public ?int $selectedInstrumentId = null;

    public ?int $activeAreaId = null;

    public ?int $activeParameterId = null;

    public string $activeSection = 'systems'; // 'systems', 'implementation', 'outcomes', 'bestpractices'

    public string $docFilter = 'all'; // 'all', 'pending', 'verified', 'needs_revision'

    // Modals state
    public bool $showFlagModal = false;

    public ?int $flaggingDocId = null;

    public string $flaggingDocTitle = '';

    public string $flaggingDocCriterion = '';

    public string $revisionRemarks = '';

    public bool $showRequestRevisionsModal = false;

    public string $reworkSummaryNotes = '';

    public bool $showSubmitToIqaModal = false;

    public string $signoffNotes = '';

    public function mount($accreditation)
    {
        $this->accreditationId = $accreditation instanceof Accreditation ? $accreditation->id : (int) $accreditation;
        $user = Auth::user();

        $acc = Accreditation::with(['program.college', 'taskForce.members'])->findOrFail($this->accreditationId);

        // Security check: Must belong to Dean's college or be IQA/Admin
        if ($user && $user->hasRole('college-head') && $user->college_id && $acc->program && $acc->program->college_id !== $user->college_id) {
            abort(403, 'Unauthorized access to another college\'s accreditation repository.');
        }

        $this->resolveInstrument();
        $this->initializeActiveSelection();
    }

    public function resolveInstrument(): ?Instrument
    {
        $acc = $this->accreditation;
        $user = Auth::user();

        $instrument = Instrument::with(['areas.parameters.criteria.complianceRequirements.documentLinks.document.uploader'])
            ->where('accreditation_id', $acc->id)
            ->where(function ($q) {
                $q->where('code', 'like', '%SUPP%')
                    ->orWhere('name', 'like', '%Supporting%');
            })
            ->first();

        if (! $instrument) {
            $instrument = Instrument::with(['areas.parameters.criteria.complianceRequirements.documentLinks.document.uploader'])
                ->where('accreditation_id', $acc->id)
                ->first();
        }

        if (! $instrument && $acc->program_id) {
            $instrument = Instrument::with(['areas.parameters.criteria.complianceRequirements.documentLinks.document.uploader'])
                ->where('program_id', $acc->program_id)
                ->first();
        }

        if ((! $instrument || $instrument->areas->isEmpty()) && $acc->program) {
            $masterTemplate = Instrument::where('code', 'INST-PROG-SUPPORTING-DOCS')->first()
                ?? Instrument::where('is_template', true)->where('accreditation_type', 'program')->whereHas('areas')->first();

            if ($masterTemplate) {
                $instrument = $masterTemplate->cloneForProgram($acc->program, $acc, $user);
                $instrument->load('areas.parameters.criteria.complianceRequirements.documentLinks.document.uploader');
            }
        }

        if ($instrument) {
            $this->selectedInstrumentId = $instrument->id;
        }

        return $instrument;
    }

    public function initializeActiveSelection(): void
    {
        $instrument = $this->instrument;
        if ($instrument && $instrument->areas->isNotEmpty()) {
            if (! $this->activeAreaId || ! $instrument->areas->contains('id', $this->activeAreaId)) {
                $this->activeAreaId = $instrument->areas->first()->id;
            }

            $activeArea = $instrument->areas->firstWhere('id', $this->activeAreaId);
            if ($activeArea && $activeArea->parameters->isNotEmpty()) {
                if (! $this->activeParameterId || ! $activeArea->parameters->contains('id', $this->activeParameterId)) {
                    $this->activeParameterId = $activeArea->parameters->first()->id;
                }
            }
        }
    }

    public function selectArea(int $areaId): void
    {
        $this->activeAreaId = $areaId;
        $area = InstrumentArea::with('parameters')->find($areaId);
        if ($area && $area->parameters->isNotEmpty()) {
            $this->activeParameterId = $area->parameters->first()->id;
        } else {
            $this->activeParameterId = null;
        }
        $this->activeSection = 'systems';
    }

    public function selectParameter(int $parameterId): void
    {
        $this->activeParameterId = $parameterId;
    }

    public function selectSection(string $section): void
    {
        $this->activeSection = in_array($section, ['systems', 'implementation', 'outcomes', 'bestpractices']) ? $section : 'systems';
    }

    public function getAccreditationProperty(): Accreditation
    {
        return Accreditation::with(['program.college', 'taskForce.members'])->findOrFail($this->accreditationId);
    }

    public function getInstrumentProperty(): ?Instrument
    {
        if ($this->selectedInstrumentId) {
            $inst = Instrument::with([
                'areas.parameters.criteria.complianceRequirements.documentLinks.document.uploader',
            ])->find($this->selectedInstrumentId);
            if ($inst) {
                return $inst;
            }
        }

        $acc = $this->accreditation;

        $instrument = Instrument::with([
            'areas.parameters.criteria.complianceRequirements.documentLinks.document.uploader',
        ])
            ->where('accreditation_id', $acc->id)
            ->where(function ($q) {
                $q->where('code', 'like', '%SUPP%')
                    ->orWhere('name', 'like', '%Supporting%');
            })
            ->first();

        if (! $instrument) {
            $instrument = Instrument::with([
                'areas.parameters.criteria.complianceRequirements.documentLinks.document.uploader',
            ])
                ->where('accreditation_id', $acc->id)
                ->first();
        }

        if (! $instrument && $acc->program_id) {
            $instrument = Instrument::with([
                'areas.parameters.criteria.complianceRequirements.documentLinks.document.uploader',
            ])
                ->where('program_id', $acc->program_id)
                ->first();
        }

        return $instrument;
    }

    public function getStatsProperty(): array
    {
        $acc = $this->accreditation;

        $documents = Document::whereHas('accreditationLinks.complianceRequirement', function ($q) use ($acc) {
            $q->where('accreditation_id', $acc->id);
        })->get();

        $totalDocs = $documents->count();
        $verifiedDocs = $documents->where('status', 'verified')->count();
        $pendingDocs = $documents->where('status', 'pending')->count();
        $flaggedDocs = $documents->where('status', 'needs_revision')->count();

        $instrument = $this->instrument;
        $totalCriteria = 0;
        $totalAreas = 0;

        if ($instrument) {
            $totalAreas = $instrument->areas->count();
            foreach ($instrument->areas as $area) {
                foreach ($area->parameters as $param) {
                    $totalCriteria += $param->criteria->count();
                }
            }
        }

        $readinessPct = $totalDocs > 0 ? (int) round(($verifiedDocs / $totalDocs) * 100) : 0;

        return [
            'totalAreas' => $totalAreas ?: 10,
            'totalCriteria' => $totalCriteria ?: 45,
            'totalDocs' => $totalDocs,
            'verifiedDocs' => $verifiedDocs,
            'pendingDocs' => $pendingDocs,
            'flaggedDocs' => $flaggedDocs,
            'readinessPct' => $readinessPct,
        ];
    }

    /**
     * Mark a document as verified by the College Dean.
     * Security Reasoning: Only authorized Deans or higher can verify compliance documents;
     * records an immutable audit entry and sets verification timestamps.
     */
    public function verifyDocument(int $docId): void
    {
        $user = Auth::user();
        $acc = $this->accreditation;

        $doc = Document::where('program_id', $acc->program_id)->findOrFail($docId);
        $doc->update([
            'status' => 'verified',
            'confirmed_by' => $user->id,
            'confirmed_at' => now(),
        ]);

        AuditLog::create([
            'user_id' => $user->id,
            'action' => "College Dean verified document '{$doc->title}' for {$acc->program->name}",
            'target_type' => 'Document',
            'target_id' => $doc->id,
            'timestamp' => now(),
        ]);

        $this->dispatch('document-verified', title: 'Document Verified', message: "'{$doc->title}' marked as verified.");
    }

    public function openFlagModal(int $docId): void
    {
        $acc = $this->accreditation;
        $doc = Document::where('program_id', $acc->program_id)->findOrFail($docId);

        $this->flaggingDocId = $doc->id;
        $this->flaggingDocTitle = $doc->title;
        $link = $doc->accreditationLinks->first();
        $this->flaggingDocCriterion = $link?->complianceRequirement?->criterion?->code ?? 'General Criterion';
        $this->revisionRemarks = '';
        $this->showFlagModal = true;
    }

    public function closeFlagModal(): void
    {
        $this->showFlagModal = false;
        $this->flaggingDocId = null;
        $this->flaggingDocTitle = '';
        $this->revisionRemarks = '';
    }

    /**
     * Flag a document as needing revision with specific review remarks.
     */
    public function submitFlagDocument(): void
    {
        $this->validate([
            'revisionRemarks' => 'required|string|min:5|max:1000',
        ]);

        $user = Auth::user();
        $acc = $this->accreditation;
        $doc = Document::where('program_id', $acc->program_id)->findOrFail($this->flaggingDocId);

        $doc->update([
            'status' => 'needs_revision',
        ]);

        // Record structured review entry
        DocumentReview::create([
            'document_id' => $doc->id,
            'reviewed_by' => $user->id,
            'decision' => 'needs_revision',
            'remarks' => $this->revisionRemarks,
            'reviewed_at' => now(),
        ]);

        // Notify uploader or Task Force
        if ($doc->uploaded_by && $doc->uploaded_by !== $user->id) {
            Notification::create([
                'user_id' => $doc->uploaded_by,
                'type' => 'document_flagged',
                'title' => 'Document Needs Revision',
                'message' => "College Dean requested revisions on '{$doc->title}': {$this->revisionRemarks}",
                'related_document_id' => $doc->id,
                'is_read' => false,
            ]);
        }

        AuditLog::create([
            'user_id' => $user->id,
            'action' => "College Dean flagged document '{$doc->title}' for revisions: {$this->revisionRemarks}",
            'target_type' => 'Document',
            'target_id' => $doc->id,
            'timestamp' => now(),
        ]);

        $this->closeFlagModal();
        $this->dispatch('document-flagged', title: 'Document Flagged', message: 'Document marked for revision. Task Force notified.');
    }

    public function openRequestRevisionsModal(): void
    {
        $this->reworkSummaryNotes = '';
        $this->showRequestRevisionsModal = true;
    }

    public function closeRequestRevisionsModal(): void
    {
        $this->showRequestRevisionsModal = false;
        $this->reworkSummaryNotes = '';
    }

    /**
     * Return repository to Task Force with summary rework notes.
     */
    public function confirmRequestRevisions(): void
    {
        $this->validate([
            'reworkSummaryNotes' => 'required|string|min:3|max:2000',
        ]);

        $user = Auth::user();
        $acc = $this->accreditation;

        $acc->update([
            'status' => 'document_preparation',
        ]);

        // Notify Task Force members
        $notifiedUserIds = [];
        if ($acc->taskForce && $acc->taskForce->members) {
            foreach ($acc->taskForce->members as $member) {
                $memberId = $member->id ?? $member->user_id;
                if ($memberId && $memberId !== $user->id && ! in_array($memberId, $notifiedUserIds)) {
                    $notifiedUserIds[] = $memberId;
                    Notification::create([
                        'user_id' => $memberId,
                        'type' => 'revisions_requested',
                        'title' => 'Evidence Revisions Requested',
                        'message' => "The College Dean has requested revisions for {$acc->program->name}: {$this->reworkSummaryNotes}",
                        'is_read' => false,
                    ]);
                }
            }
        }

        // Also notify any task force members assigned to this program/college
        $tfRoleId = Role::where('role_name', 'task-force-member')->value('id');
        $tfUsers = $tfRoleId ? User::where('role_id', $tfRoleId)
            ->where(function ($q) use ($acc) {
                $q->where('program_id', $acc->program_id)
                    ->orWhere('college_id', $acc->program->college_id);
            })->get() : collect();

        foreach ($tfUsers as $tf) {
            if ($tf->id !== $user->id && ! in_array($tf->id, $notifiedUserIds)) {
                $notifiedUserIds[] = $tf->id;
                Notification::create([
                    'user_id' => $tf->id,
                    'type' => 'revisions_requested',
                    'title' => 'Evidence Revisions Requested',
                    'message' => "The College Dean has requested revisions for {$acc->program->name}: {$this->reworkSummaryNotes}",
                    'is_read' => false,
                ]);
            }
        }

        AuditLog::create([
            'user_id' => $user->id,
            'action' => "College Dean requested Task Force revisions for {$acc->program->name}: {$this->reworkSummaryNotes}",
            'target_type' => 'Accreditation',
            'target_id' => $acc->id,
            'timestamp' => now(),
        ]);

        session()->flash('success', 'Evidence repository returned to Task Force for revisions.');
        $this->redirect(route('dashboard.college-head'));
    }

    public function openSubmitToIqaModal(): void
    {
        $this->signoffNotes = '';
        $this->showSubmitToIqaModal = true;
    }

    public function closeSubmitToIqaModal(): void
    {
        $this->showSubmitToIqaModal = false;
        $this->signoffNotes = '';
    }

    /**
     * Submit verified repository to Central IQA Office.
     */
    public function confirmSubmitToIqa(): void
    {
        $user = Auth::user();
        $acc = $this->accreditation;

        $acc->update([
            'status' => 'submitted',
        ]);

        // Notify Central IQA Staff
        $iqaRole = Role::where('role_name', 'iqa-staff')->first();
        if ($iqaRole) {
            $iqaStaffUsers = User::where('role_id', $iqaRole->id)->get();
            foreach ($iqaStaffUsers as $staff) {
                Notification::create([
                    'user_id' => $staff->id,
                    'type' => 'accreditation_submitted',
                    'title' => 'Accreditation Repository Submitted',
                    'message' => "College Dean of {$acc->program->college?->name} verified and submitted evidence repository for {$acc->program->name}.",
                    'is_read' => false,
                ]);
            }
        }

        AuditLog::create([
            'user_id' => $user->id,
            'action' => "College Dean approved and submitted evidence repository for {$acc->program->name} to Central IQA Office.",
            'target_type' => 'Accreditation',
            'target_id' => $acc->id,
            'timestamp' => now(),
        ]);

        session()->flash('success', "Accreditation repository for {$acc->program->name} successfully verified and submitted to the IQA Office!");
        $this->redirect(route('dashboard.college-head'));
    }

    public function render()
    {
        $acc = $this->accreditation;
        $instrument = $this->instrument;
        $stats = $this->stats;

        $activeArea = $instrument?->areas->firstWhere('id', $this->activeAreaId) ?? $instrument?->areas->first();
        $activeParameter = $activeArea?->parameters->firstWhere('id', $this->activeParameterId) ?? $activeArea?->parameters->first();

        $criteria = $activeParameter?->criteria->where('section', $this->activeSection) ?? collect();

        // Load all evidence documents specifically linked to this accreditation
        $allProgramDocs = Document::with(['uploader', 'accreditationLinks.complianceRequirement.criterion.parameter.area'])
            ->whereHas('accreditationLinks.complianceRequirement', function ($q) use ($acc) {
                $q->where('accreditation_id', $acc->id);
            })
            ->get();

        return view('livewire.college-head.dean-verification', [
            'acc' => $acc,
            'instrument' => $instrument,
            'stats' => $stats,
            'activeArea' => $activeArea,
            'activeParameter' => $activeParameter,
            'criteria' => $criteria,
            'allProgramDocs' => $allProgramDocs,
        ]);
    }
}
