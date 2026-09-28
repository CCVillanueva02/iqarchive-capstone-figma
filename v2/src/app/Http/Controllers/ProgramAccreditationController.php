<?php

/**
 * ============================================================================
 * IQArchive v2 — Program Accreditation Controller
 * ============================================================================
 * File: app/Http/Controllers/ProgramAccreditationController.php
 * Responsibility: Handles 3-tier navigation for Program Accreditation (Colleges,
 *                 Degree Programs, and the 5 Document Types workspace).
 * Architecture: Controller Layer (Delegates business logic to ProgramAccreditationService)
 * Security Context: Strictly authorizes IQA Staff, Members, and Administrators.
 * ============================================================================
 */

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\College;
use App\Models\Document;
use App\Models\Program;
use App\Services\ProgramAccreditationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProgramAccreditationController extends Controller
{
    public function __construct(
        protected ProgramAccreditationService $accreditationService
    ) {}

    /**
     * Display Program Accreditation workspace across College, Program, or Category levels.
     *
     * Security Reasoning: Accessible to authenticated IQA staff, members, and sysadmins.
     * Non-IQA users are redirected or restricted by role boundaries.
     */
    public function index(Request $request): Response
    {
        $this->authorizeIqaAccess();

        $collegeId = $request->integer('college_id');
        $programId = $request->integer('program_id');
        $search = $request->input('search');

        // Tier 1: College Selection Grid
        if (! $collegeId) {
            return Inertia::render('Documents/Program-Accreditation/Index', [
                'currentTier' => 1,
                'colleges' => $this->accreditationService->getColleges($search),
                'selectedCollege' => null,
                'selectedProgram' => null,
                'programs' => [],
                'documentTypes' => [],
                'instrument' => null,
                'filters' => ['search' => $search ?? ''],
            ]);
        }

        $college = College::withCount('programs')->findOrFail($collegeId);

        // Tier 2: Programs Selection Grid for Selected College
        if (! $programId) {
            return Inertia::render('Documents/Program-Accreditation/Index', [
                'currentTier' => 2,
                'colleges' => [],
                'selectedCollege' => $college,
                'selectedProgram' => null,
                'programs' => $this->accreditationService->getProgramsForCollege($college->id, $search),
                'documentTypes' => [],
                'instrument' => null,
                'filters' => ['search' => $search ?? ''],
            ]);
        }

        // Tier 3: Program Document Hub & Category Workspaces
        $program = Program::where('college_id', $college->id)->withCount('documents')->findOrFail($programId);
        $documents = Document::where('college_id', $college->id)
            ->where('program_id', $program->id)
            ->with(['uploader:id,name,email', 'category:id,name'])
            ->latest('id')
            ->get();

        return Inertia::render('Documents/Program-Accreditation/Index', [
            'currentTier' => 3,
            'colleges' => [],
            'selectedCollege' => $college,
            'selectedProgram' => $program,
            'programs' => [],
            'documentTypes' => $this->accreditationService->resolveAllowedDocumentTypes($program->current_level),
            'activeCategory' => $request->input('category', 'hub'),
            'instrument' => $this->accreditationService->getActiveInstrumentHierarchy(),
            'documents' => $documents,
            'filters' => ['search' => $search ?? ''],
        ]);
    }

    /**
     * Store new academic degree program under a college unit.
     */
    public function storeProgram(Request $request): RedirectResponse
    {
        $this->authorizeIqaAccess();

        $validated = $request->validate([
            'college_id' => ['required', 'exists:colleges,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:programs,code'],
            'current_level' => ['required', 'string', 'max:50'],
        ]);

        $college = College::findOrFail($validated['college_id']);
        $program = $this->accreditationService->storeProgram($college, $validated);

        AuditLog::create([
            'user_id' => Auth::id(),
            'college_id' => $college->id,
            'action' => 'PROGRAM_REGISTERED',
            'target_type' => Program::class,
            'target_id' => $program->id,
            'details' => ['code' => $program->code, 'name' => $program->name],
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('documents.program-accreditation', [
            'college_id' => $college->id,
        ])->with('success', "Degree program {$program->code} registered successfully.");
    }

    /**
     * Store and link an accreditation document to a program.
     */
    public function storeDocument(Request $request): RedirectResponse
    {
        $this->authorizeIqaAccess();

        $validated = $request->validate([
            'program_id' => ['required', 'exists:programs,id'],
            'title' => ['required', 'string', 'max:255'],
            'category_type' => ['required', 'string'],
            'criterion_id' => ['nullable', 'exists:instrument_criteria,id'],
            'file' => ['required', 'file', 'mimes:pdf,docx,xlsx,png,jpg', 'max:51200'],
        ]);

        $program = Program::findOrFail($validated['program_id']);

        $document = $this->accreditationService->storeProgramDocument(
            program: $program,
            file: $request->file('file'),
            title: $validated['title'],
            categoryType: $validated['category_type'],
            uploader: Auth::user(),
            criterionId: $validated['criterion_id'] ?? null
        );

        AuditLog::create([
            'user_id' => Auth::id(),
            'college_id' => $program->college_id,
            'action' => 'PROGRAM_DOCUMENT_UPLOADED',
            'target_type' => Document::class,
            'target_id' => $document->id,
            'details' => ['title' => $document->title, 'program_id' => $program->id],
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', "Document '{$document->title}' uploaded successfully.");
    }

    /**
     * Security Gate: Ensures only authorized IQA Staff or Administrators proceed.
     */
    protected function authorizeIqaAccess(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user) {
            abort(401, 'Unauthenticated');
        }

        // IQA staff, IQA members, and system administrators are authorized
        $isAuthorized = $user->hasRole(['iqa_staff', 'iqa_member', 'system_admin', 'super_admin'])
            || $user->can('create', Document::class);

        if (! $isAuthorized) {
            abort(403, 'Unauthorized. Access is restricted to IQA Staff and Administrators.');
        }
    }
}
