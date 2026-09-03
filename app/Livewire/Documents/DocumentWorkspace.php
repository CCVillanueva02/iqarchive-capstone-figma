<?php

namespace App\Livewire\Documents;

use App\Models\Accreditation;
use App\Models\AccreditationDocumentLink;
use App\Models\AuditLog;
use App\Models\College;
use App\Models\ComplianceRequirement;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Instrument;
use App\Models\InstrumentArea;
use App\Models\InstrumentParameter;
use App\Models\Office;
use App\Models\Program;
use App\Models\SelfSurveyArea;
use App\Models\SelfSurveyParameter;
use App\Models\SelfSurveyRating;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Title('Document Repository & Accreditation Workspace')]
#[Layout('layouts.app')]
class DocumentWorkspace extends Component
{
    use WithFileUploads;
    use WithPagination;

    // Navigation and tab state
    #[Url(as: 'tab')]
    public string $activeTab = 'common-documents'; // 'common-documents', 'program-accreditation', 'institutional-accreditation'

    #[Url(as: 'category')]
    public string $programCategory = 'supporting-documents'; // 'supporting-documents', 'self-survey', 'compliance-reports', 'narrative-profile'

    // Role-based scoping flags
    public ?int $userCollegeId = null;

    public ?int $userProgramId = null;

    public bool $isCollegeLocked = false;

    public bool $isProgramLocked = false;

    public bool $canAccessCommonDocs = true;

    public bool $canAccessInstitutionalDocs = false;

    public bool $isUnrestricted = false;

    public string $userRole = '';

    // Selection state
    #[Url(as: 'college')]
    public ?int $selectedCollegeId = null;

    #[Url(as: 'program')]
    public ?int $selectedProgramId = null;

    public ?int $selectedOfficeId = null;

    public ?int $selectedCategoryId = null;

    // Search and filter state
    public string $searchQuery = '';

    public string $statusFilter = 'all';

    // Program accreditation area navigation
    public ?int $activeAreaId = null;

    public ?int $activeParameterId = null;

    public string $activeSection = 'systems'; // 'systems', 'implementation', 'outcomes', 'best_practices'

    // Institutional self-survey state
    public ?int $surveyActiveAreaId = null;

    public array $surveyRatings = []; // [indicator_id => rating_val]

    // Modals & detail drawer state
    public bool $showCommonUploadModal = false;

    public bool $showEvidenceUploadModal = false;

    public bool $showDetailDrawer = false;

    public ?int $drawerDocumentId = null;

    // Common upload form
    public $uploadFile = null;

    public string $uploadTitle = '';

    public ?int $uploadOfficeId = null;

    public ?int $uploadCategoryId = null;

    public string $uploadDescription = '';

    // Program evidence upload form
    public $evidenceFile = null;

    public string $evidenceTitle = '';

    public string $evidenceDescription = '';

    public ?int $evidenceCriterionId = null;

    public ?string $evidenceCriterionCode = null;

    public function mount()
    {
        $user = Auth::user();
        if (! $user) {
            abort(403, 'Unauthenticated');
        }

        // Determine active role and permission matrix
        $this->isUnrestricted = $user->hasRole(['iqa-staff', 'iqa-admin', 'system-administrator']);
        $this->canAccessCommonDocs = $this->isUnrestricted || $user->hasRole(['college-head', 'task-force-member']);
        $this->canAccessInstitutionalDocs = $this->isUnrestricted;

        if ($user->hasRole('system-administrator')) {
            $this->userRole = 'system-administrator';
        } elseif ($user->hasRole(['iqa-staff', 'iqa-admin'])) {
            $this->userRole = 'iqa-staff';
        } elseif ($user->hasRole('college-head')) {
            $this->userRole = 'college-head';
        } elseif ($user->hasRole('task-force-member')) {
            $this->userRole = 'task-force-member';
        } else {
            $this->userRole = $user->role ?? 'iqa-staff';
        }

        // Enforce RBAC Tab boundaries
        if (! $this->canAccessCommonDocs && $this->activeTab === 'common-documents') {
            $this->activeTab = 'program-accreditation';
        }
        if (! $this->canAccessInstitutionalDocs && $this->activeTab === 'institutional-accreditation') {
            $this->activeTab = 'program-accreditation';
        }

        // Apply College and Program scoping
        if ($this->userRole === 'college-head') {
            $this->userCollegeId = $user->college_id;
            $this->selectedCollegeId = $user->college_id;
            $this->isCollegeLocked = true;

            // Pre-select first program under this college if not already set or outside scope
            $validProgram = Program::where('college_id', $this->selectedCollegeId)->find($this->selectedProgramId);
            if (! $validProgram) {
                $this->selectedProgramId = Program::where('college_id', $this->selectedCollegeId)->value('id');
            }
        } elseif ($this->userRole === 'task-force-member') {
            // Check relational task force pivot first
            $tf = $user->taskForces()->whereNotNull('program_id')->first();
            $resolvedProgram = $tf?->program;

            if (! $resolvedProgram && $user->program_id) {
                $resolvedProgram = Program::find($user->program_id);
            }

            if ($resolvedProgram) {
                $this->userProgramId = $resolvedProgram->id;
                $this->selectedProgramId = $resolvedProgram->id;
                $this->userCollegeId = $resolvedProgram->college_id;
                $this->selectedCollegeId = $resolvedProgram->college_id;
                $this->isCollegeLocked = true;
                $this->isProgramLocked = true;
            } else {
                // Fallback to user's college if no specific program assigned
                $this->userCollegeId = $user->college_id;
                $this->selectedCollegeId = $user->college_id;
                $this->isCollegeLocked = true;
                $this->selectedProgramId = Program::where('college_id', $this->selectedCollegeId)->value('id');
            }
        } else {
            // Unrestricted roles: default to first college & program if none selected
            if (! $this->selectedCollegeId) {
                $this->selectedCollegeId = College::orderBy('name')->value('id');
            }
            if (! $this->selectedProgramId && $this->selectedCollegeId) {
                $this->selectedProgramId = Program::where('college_id', $this->selectedCollegeId)->orderBy('name')->value('id');
            }
        }

        // Initialize active area & parameter for Program Accreditation
        $this->initializeProgramAreaState();

        // Initialize Institutional Self-Survey Area & Ratings
        $this->initializeSurveyState();
    }

    public function initializeProgramAreaState()
    {
        if (! $this->activeAreaId) {
            $instrument = $this->resolveActiveInstrument();
            if ($instrument) {
                $firstArea = $instrument->areas()->orderBy('order')->first();
                $this->activeAreaId = $firstArea?->id;
                $this->activeParameterId = $firstArea?->parameters()->orderBy('order')->first()?->id;
            }
        }
    }

    public function resolveActiveInstrument(): ?Instrument
    {
        if ($this->selectedProgramId) {
            $program = Program::find($this->selectedProgramId);
            $accred = $program?->accreditations()->latest()->first();
            if ($accred && $accred->instrument) {
                return $accred->instrument;
            }
        }

        return Instrument::where('code', 'INST-PROG-SUPPORTING-DOCS')->first()
            ?? Instrument::where('is_template', true)->first();
    }

    public function initializeSurveyState()
    {
        if (! $this->surveyActiveAreaId) {
            $this->surveyActiveAreaId = SelfSurveyArea::orderBy('sort_order')->value('id');
        }

        // Load all saved ratings by the authenticated user
        $ratings = SelfSurveyRating::where('rated_by', Auth::id())->get();
        foreach ($ratings as $r) {
            $this->surveyRatings[$r->indicator_id] = $r->rating === null ? 'NA' : (string) $r->rating;
        }
    }

    public function switchTab(string $tab)
    {
        if ($tab === 'institutional-accreditation' && ! $this->canAccessInstitutionalDocs) {
            return;
        }
        if ($tab === 'common-documents' && ! $this->canAccessCommonDocs) {
            return;
        }

        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function switchProgramCategory(string $category)
    {
        $this->programCategory = $category;
    }

    public function updatedSelectedCollegeId($value): void
    {
        if ($this->isCollegeLocked) {
            $this->selectedCollegeId = $this->userCollegeId;
        }
    }

    public function updatedSelectedProgramId($value): void
    {
        if ($this->isProgramLocked) {
            $this->selectedProgramId = $this->userProgramId;
        }
    }

    public function selectCollege(int $collegeId)
    {
        if ($this->isCollegeLocked) {
            return;
        }

        $this->selectedCollegeId = $collegeId;
        $this->selectedProgramId = Program::where('college_id', $collegeId)->orderBy('name')->value('id');
        $this->activeAreaId = null;
        $this->activeParameterId = null;
        $this->initializeProgramAreaState();
    }

    public function selectProgram(int $programId)
    {
        if ($this->isProgramLocked) {
            return;
        }

        if ($this->isCollegeLocked) {
            $prog = Program::find($programId);
            if (! $prog || $prog->college_id !== $this->userCollegeId) {
                return;
            }
        }

        $this->selectedProgramId = $programId;
        $this->activeAreaId = null;
        $this->activeParameterId = null;
        $this->initializeProgramAreaState();
    }

    public function selectArea(int $areaId)
    {
        $this->activeAreaId = $areaId;
        $area = InstrumentArea::find($areaId);
        $this->activeParameterId = $area?->parameters()->orderBy('order')->value('id');
    }

    public function selectParameter(int $paramId)
    {
        $this->activeParameterId = $paramId;
    }

    public function selectSection(string $section)
    {
        $this->activeSection = $section;
    }

    public function selectSurveyArea(int $areaId)
    {
        $this->surveyActiveAreaId = $areaId;
    }

    // ─────────────────────────────────────────────────────────────
    // Self-Survey Scoring & Autosave (Formulas matching Phase 4)
    // ─────────────────────────────────────────────────────────────

    public function updateSurveyRating(int $indicatorId, ?string $value)
    {
        $userId = Auth::id();

        if ($value === '' || $value === null) {
            unset($this->surveyRatings[$indicatorId]);
            SelfSurveyRating::where('indicator_id', $indicatorId)->where('rated_by', $userId)->delete();

            return;
        }

        $this->surveyRatings[$indicatorId] = $value;

        if ($value === 'NA') {
            SelfSurveyRating::updateOrCreate(
                ['indicator_id' => $indicatorId, 'rated_by' => $userId],
                ['rating' => null]
            );
        } else {
            $numericRating = max(0, min(5, (int) $value));
            SelfSurveyRating::updateOrCreate(
                ['indicator_id' => $indicatorId, 'rated_by' => $userId],
                ['rating' => $numericRating]
            );
        }
    }

    public function calculateSectionMean($indicators): ?float
    {
        if (empty($indicators) || $indicators->isEmpty()) {
            return null;
        }

        // Exclude NA indicators completely from valid count
        $validIndicators = $indicators->filter(function ($ind) {
            return ($this->surveyRatings[$ind->id] ?? null) !== 'NA';
        });

        if ($validIndicators->isEmpty()) {
            return null;
        }

        $ratedValues = [];
        foreach ($validIndicators as $ind) {
            $val = $this->surveyRatings[$ind->id] ?? null;
            if ($val !== null && $val !== '' && $val !== 'NA') {
                $ratedValues[] = (float) $val;
            }
        }

        if (empty($ratedValues)) {
            return null;
        }

        // Divide by total valid indicators so partial completion accurately reflects partial progress
        return round(array_sum($ratedValues) / $validIndicators->count(), 2);
    }

    public function calculateParameterMean(SelfSurveyParameter $param): ?float
    {
        $systemMean = $this->calculateSectionMean($param->systemIndicators);
        $implMean = $this->calculateSectionMean($param->implementationIndicators);
        $outcomeMean = $this->calculateSectionMean($param->outcomeIndicators);

        $validMeans = array_filter([$systemMean, $implMean, $outcomeMean], fn ($m) => $m !== null);

        if (empty($validMeans)) {
            return null;
        }

        return round(array_sum($validMeans) / count($validMeans), 2);
    }

    public function calculateAreaCompletionPct(SelfSurveyArea $area): int
    {
        $allIndicators = $area->parameters->flatMap->indicators;
        if ($allIndicators->isEmpty()) {
            return 0;
        }

        $total = $allIndicators->count();
        $rated = $allIndicators->filter(function ($ind) {
            $val = $this->surveyRatings[$ind->id] ?? null;

            return $val !== null && $val !== '';
        })->count();

        return (int) round(($rated / $total) * 100);
    }

    public function saveBestPractices(int $parameterId, string $text)
    {
        SelfSurveyParameter::where('id', $parameterId)->update(['best_practices' => $text]);
        session()->flash('status', 'Best practices saved successfully.');
    }

    // ─────────────────────────────────────────────────────────────
    // Livewire Native Upload Pipelines (Subphase 4.2)
    // ─────────────────────────────────────────────────────────────

    public function openCommonUploadModal()
    {
        $this->reset(['uploadFile', 'uploadTitle', 'uploadDescription']);
        $this->uploadOfficeId = Office::value('id');
        $this->uploadCategoryId = DocumentCategory::value('id');
        $this->showCommonUploadModal = true;
    }

    public function closeCommonUploadModal()
    {
        $this->showCommonUploadModal = false;
        $this->reset(['uploadFile', 'uploadTitle', 'uploadDescription']);
    }

    public function uploadCommonDocument()
    {
        $this->validate([
            'uploadFile' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:25600',
            'uploadTitle' => 'required|string|max:255',
            'uploadOfficeId' => 'required|exists:offices,id',
            'uploadCategoryId' => 'required|exists:document_categories,id',
            'uploadDescription' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $file = $this->uploadFile;
        $filename = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
        $filePath = $file->storeAs('documents', $filename, 'public');

        $ext = strtoupper($file->getClientOriginalExtension());
        $sizeBytes = $file->getSize();
        $sizeStr = round($sizeBytes / 1048576, 2).' MB';

        $status = $this->isUnrestricted ? 'Verified' : 'Pending';

        $doc = Document::create([
            'title' => $this->uploadTitle,
            'category_id' => $this->uploadCategoryId,
            'office_id' => $this->uploadOfficeId,
            'uploaded_by' => $user->id,
            'file_path' => $filePath,
            'file_extension' => $ext,
            'file_size' => $sizeStr,
            'status' => $status,
            'description' => $this->uploadDescription,
        ]);

        // Audit Trail
        AuditLog::create([
            'user_id' => $user->id,
            'action' => "Uploaded institutional common document '{$doc->title}'",
            'target_type' => 'Document',
            'target_id' => $doc->id,
            'timestamp' => now(),
        ]);

        $this->closeCommonUploadModal();
        session()->flash('status', "Document '{$doc->title}' uploaded successfully.");
    }

    public function openEvidenceUploadModal(?int $criterionId = null, ?string $criterionCode = null)
    {
        $this->reset(['evidenceFile', 'evidenceTitle', 'evidenceDescription']);
        $this->evidenceCriterionId = $criterionId;
        $this->evidenceCriterionCode = $criterionCode;
        $this->showEvidenceUploadModal = true;
    }

    public function closeEvidenceUploadModal()
    {
        $this->showEvidenceUploadModal = false;
        $this->reset(['evidenceFile', 'evidenceTitle', 'evidenceDescription', 'evidenceCriterionId', 'evidenceCriterionCode']);
    }

    public function uploadEvidenceDocument()
    {
        $this->validate([
            'evidenceFile' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:25600',
            'evidenceTitle' => 'required|string|max:255',
            'selectedProgramId' => 'required|exists:programs,id',
            'evidenceDescription' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $program = Program::with('college')->findOrFail($this->selectedProgramId);

        // RBAC Authorization Gate
        if (! $this->isUnrestricted) {
            if ($user->hasRole('college-head')) {
                if ($user->college_id && $program->college_id !== $user->college_id) {
                    abort(403, 'Unauthorized for this college program.');
                }
            } elseif ($user->hasRole('task-force-member')) {
                $isAssigned = ($user->program_id === $program->id) ||
                              ($user->college_id === $program->college_id) ||
                              $user->taskForces()->where('program_id', $program->id)->exists();

                if (! $isAssigned) {
                    abort(403, 'Unauthorized. You are not assigned to this program Task Force.');
                }
            }
        }

        $file = $this->evidenceFile;
        $filename = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
        $filePath = $file->storeAs("documents/evidence/{$program->id}", $filename, 'public');

        $ext = strtoupper($file->getClientOriginalExtension());
        $sizeBytes = $file->getSize();
        $sizeStr = round($sizeBytes / 1048576, 2).' MB';

        $evidenceCategory = DocumentCategory::firstOrCreate(
            ['name' => 'Program Evidence'],
            ['description' => 'Supporting evidence uploaded for program accreditation criteria']
        );

        $doc = Document::create([
            'title' => $this->evidenceTitle,
            'category_id' => $evidenceCategory->id,
            'program_id' => $program->id,
            'uploaded_by' => $user->id,
            'file_path' => $filePath,
            'status' => 'Pending',
            'visibility' => 'private',
            'description' => $this->evidenceDescription,
        ]);

        // Link to compliance requirement if criterion is selected
        $accreditation = $program->accreditations()->latest()->first();
        if ($this->evidenceCriterionId && $accreditation) {
            $req = ComplianceRequirement::firstOrCreate([
                'accreditation_id' => $accreditation->id,
                'program_id' => $program->id,
                'instrument_criterion_id' => $this->evidenceCriterionId,
            ], [
                'instrument_id' => $accreditation->instrument_id,
                'description' => $this->evidenceTitle,
                'status' => 'pending',
            ]);

            AccreditationDocumentLink::firstOrCreate([
                'document_id' => $doc->id,
                'compliance_requirement_id' => $req->id,
            ]);
        }

        // Audit Trail
        $critLabel = $this->evidenceCriterionCode ?? 'General Benchmark';
        AuditLog::create([
            'user_id' => $user->id,
            'action' => "Uploaded evidence document '{$doc->title}' for criterion {$critLabel} in {$program->name}",
            'target_type' => 'Document',
            'target_id' => $doc->id,
            'timestamp' => now(),
        ]);

        $this->closeEvidenceUploadModal();
        session()->flash('status', "Evidence document '{$doc->title}' uploaded successfully.");
    }

    // ─────────────────────────────────────────────────────────────
    // Detail Drawer & Document Management Actions
    // ─────────────────────────────────────────────────────────────

    public function viewDocumentDetails(int $documentId)
    {
        $this->drawerDocumentId = $documentId;
        $this->showDetailDrawer = true;
    }

    public function closeDetailDrawer()
    {
        $this->showDetailDrawer = false;
        $this->drawerDocumentId = null;
    }

    public function updateDocumentStatus(int $documentId, string $newStatus)
    {
        $user = Auth::user();
        if (! $this->isUnrestricted && ! $user->hasRole('college-head')) {
            abort(403, 'Unauthorized to update document verification status.');
        }

        $doc = Document::findOrFail($documentId);
        $oldStatus = $doc->status;
        $doc->update(['status' => $newStatus]);

        AuditLog::create([
            'user_id' => $user->id,
            'action' => "Updated document '{$doc->title}' status from {$oldStatus} to {$newStatus}",
            'target_type' => 'Document',
            'target_id' => $doc->id,
            'timestamp' => now(),
        ]);

        session()->flash('status', "Document status updated to {$newStatus}.");
    }

    public function deleteDocument(int $documentId)
    {
        $user = Auth::user();
        $doc = Document::findOrFail($documentId);

        if (! $this->isUnrestricted && $doc->uploaded_by !== $user->id) {
            abort(403, 'Unauthorized to delete this document.');
        }

        $title = $doc->title;
        $doc->delete();

        AuditLog::create([
            'user_id' => $user->id,
            'action' => "Deleted document '{$title}'",
            'target_type' => 'Document',
            'target_id' => $documentId,
            'timestamp' => now(),
        ]);

        $this->closeDetailDrawer();
        session()->flash('status', "Document '{$title}' was successfully deleted.");
    }

    public function render()
    {
        // 1. Common Documents Query
        $commonDocuments = collect();
        if ($this->activeTab === 'common-documents' && $this->canAccessCommonDocs) {
            $query = Document::with(['uploader', 'office', 'category'])
                ->whereNull('program_id');

            if ($this->selectedOfficeId) {
                $query->where('office_id', $this->selectedOfficeId);
            }
            if ($this->selectedCategoryId) {
                $query->where('category_id', $this->selectedCategoryId);
            }
            if ($this->statusFilter !== 'all') {
                $query->where('status', $this->statusFilter);
            }
            if (! empty($this->searchQuery)) {
                $q = '%'.$this->searchQuery.'%';
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', $q)
                        ->orWhere('description', 'like', $q)
                        ->orWhereHas('uploader', fn ($u) => $u->where('first_name', 'like', $q)->orWhere('last_name', 'like', $q));
                });
            }

            $commonDocuments = $query->latest()->paginate(15);
        }

        // 2. Program Evidence Data
        $colleges = College::with('programs')->orderBy('name')->get();
        $selectedProgram = $this->selectedProgramId ? Program::with('college', 'accreditations')->find($this->selectedProgramId) : null;
        $instrument = $this->resolveActiveInstrument();

        $activeArea = null;
        $activeParameter = null;
        $evidenceDocuments = collect();

        if ($this->activeTab === 'program-accreditation') {
            if ($instrument && $this->activeAreaId) {
                $activeArea = InstrumentArea::with(['parameters.criteria'])->find($this->activeAreaId);
                if ($this->activeParameterId) {
                    $activeParameter = InstrumentParameter::with([
                        'criteria',
                        'systemsCriteria',
                        'implementationCriteria',
                        'outcomesCriteria',
                        'bestPracticesCriteria',
                    ])->find($this->activeParameterId);
                }
            }

            if ($this->selectedProgramId) {
                $evidenceQuery = Document::with(['uploader', 'accreditationLinks.complianceRequirement.criterion'])
                    ->where('program_id', $this->selectedProgramId);

                if ($this->statusFilter !== 'all') {
                    $evidenceQuery->where('status', $this->statusFilter);
                }
                if (! empty($this->searchQuery)) {
                    $q = '%'.$this->searchQuery.'%';
                    $evidenceQuery->where(function ($sub) use ($q) {
                        $sub->where('title', 'like', $q)
                            ->orWhere('description', 'like', $q);
                    });
                }

                $evidenceDocuments = $evidenceQuery->latest()->get();
            }
        }

        // 3. Institutional Survey Data
        $surveyAreas = collect();
        $surveyActiveArea = null;
        if ($this->activeTab === 'institutional-accreditation' && $this->canAccessInstitutionalDocs) {
            $surveyAreas = SelfSurveyArea::with([
                'parameters.indicators',
                'parameters.systemIndicators',
                'parameters.implementationIndicators',
                'parameters.outcomeIndicators',
            ])->orderBy('sort_order')->get();

            $surveyActiveArea = $surveyAreas->firstWhere('id', $this->surveyActiveAreaId) ?? $surveyAreas->first();
        }

        // 4. Detail Drawer Document
        $drawerDocument = $this->drawerDocumentId ? Document::with(['uploader', 'office', 'category', 'program.college'])->find($this->drawerDocumentId) : null;

        return view('livewire.documents.document-workspace', [
            'colleges' => $colleges,
            'selectedProgram' => $selectedProgram,
            'offices' => Office::orderBy('name')->get(),
            'categories' => DocumentCategory::orderBy('name')->get(),
            'commonDocuments' => $commonDocuments,
            'instrument' => $instrument,
            'activeArea' => $activeArea,
            'activeParameter' => $activeParameter,
            'evidenceDocuments' => $evidenceDocuments,
            'surveyAreas' => $surveyAreas,
            'surveyActiveArea' => $surveyActiveArea,
            'drawerDocument' => $drawerDocument,
        ]);
    }
}
