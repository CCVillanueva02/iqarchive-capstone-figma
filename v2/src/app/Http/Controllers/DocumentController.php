<?php

/**
 * ============================================================================
 * IQArchive v2 — Document Management & Evidence Controller
 * ============================================================================
 * File: app/Http/Controllers/DocumentController.php
 * Responsibility: Handles document uploads, pre-signed URL downloads, and
 *                 evidence mapping across Program, Institutional, and Common tiers.
 * Architecture: Controller Layer (Delegates storage to DocumentStorageService)
 * Security Context: Multi-tenant college_id scoping, server-side policy authorization,
 *                   15-minute temporary pre-signed S3 URLs.
 * ============================================================================
 */

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Scopes\CollegeScoped;
use App\Services\DocumentStorageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class DocumentController extends Controller
{
    public function __construct(
        protected DocumentStorageService $storageService
    ) {}

    /**
     * Display the document repository workspace.
     *
     * Security Reasoning: Authorizes viewAny before loading repository.
     * Institutional categories and common documents are accessible university-wide.
     */
    public function index(Request $request): Response|RedirectResponse
    {
        if ($request->query('tab') === 'program-accreditation') {
            return redirect()->route('documents.program-accreditation', $request->except('tab'));
        }

        $this->authorize('viewAny', Document::class);

        $offices = DocumentCategory::where('scope', 'institutional')
            ->withCount(['documents' => function ($query) {
                $query->withoutGlobalScope(CollegeScoped::class)
                    ->whereNull('college_id')
                    ->where('visibility', 'univ');
            }])
            ->orderBy('name')
            ->get();

        $selectedOfficeId = $request->integer('office_id') ?: ($offices->first()?->id ?? null);

        $docsQuery = Document::withoutGlobalScope(CollegeScoped::class)
            ->whereNull('college_id')
            ->where('visibility', 'univ')
            ->with(['uploader:id,name,email'])
            ->when($selectedOfficeId, fn ($q) => $q->where('category_id', $selectedOfficeId));

        if ($search = $request->input('search')) {
            $docsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('original_filename', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $docsQuery->where('status', $status);
        }

        $documents = $docsQuery->latest('id')->take(50)->get();

        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $canUpload = $user ? $user->can('create', Document::class) : false;

        return Inertia::render('Documents/Common-Documents/Index', [
            'activeTab' => $request->query('tab', 'common-documents'),
            'offices' => $offices,
            'selectedOfficeId' => $selectedOfficeId,
            'documents' => $documents,
            'filters' => [
                'search' => $request->input('search', ''),
                'status' => $request->input('status', ''),
            ],
            'canUpload' => $canUpload,
        ]);
    }

    /**
     * Store new institutional Common Document.
     *
     * Security Reasoning: Strictly gated by DocumentPolicy::create so only IQA Staff
     * and System Administrators can curate university-wide common repository files.
     */
    public function storeCommon(Request $request): RedirectResponse
    {
        $this->authorize('create', Document::class);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'office_id' => ['required', 'integer', 'exists:document_categories,id'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:20480'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $storageResult = $this->storageService->storeCommonDocument(
            $validated['file'],
            $validated['office_id']
        );

        $document = Document::withoutGlobalScopes()->create([
            'college_id' => null,
            'program_id' => null,
            'category_id' => $validated['office_id'],
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'original_filename' => $validated['file']->getClientOriginalName(),
            'file_path' => $storageResult['file_path'],
            'file_hash' => $storageResult['file_hash'],
            'file_size_bytes' => $storageResult['file_size'],
            'mime_type' => $storageResult['mime_type'],
            'status' => 'draft',
            'visibility' => 'univ',
        ]);

        AuditLog::create([
            'college_id' => null,
            'user_id' => Auth::id(),
            'action' => 'document.upload.common',
            'target_type' => Document::class,
            'target_id' => (string) $document->id,
            'ip_address' => $request->ip(),
            'details' => [
                'title' => $document->title,
                'category_id' => $document->category_id,
                'file_hash' => $document->file_hash,
            ],
        ]);

        return redirect()->back()->with('success', 'Common document uploaded successfully.');
    }

    /**
     * Store new institutional administrative office or unit category.
     *
     * Security Reasoning: Strictly gated by DocumentPolicy::create so only IQA Staff
     * and System Administrators can curate university-level administrative offices.
     */
    public function storeOffice(Request $request): RedirectResponse
    {
        $this->authorize('create', Document::class);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('document_categories', 'name')->where(fn ($query) => $query->where('scope', 'institutional')),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $office = DocumentCategory::create([
            'name' => $validated['name'],
            'scope' => 'institutional',
            'description' => $validated['description'] ?? null,
        ]);

        AuditLog::create([
            'college_id' => null,
            'user_id' => Auth::id(),
            'action' => 'document_category.create',
            'target_type' => DocumentCategory::class,
            'target_id' => (string) $office->id,
            'ip_address' => $request->ip(),
            'details' => [
                'name' => $office->name,
                'scope' => $office->scope,
            ],
        ]);

        return redirect()->route('documents.index', ['office_id' => $office->id])
            ->with('success', "Office '{$office->name}' added successfully.");
    }

    /**
     * Mint a 15-minute pre-signed URL for private PDF streaming.
     *
     * Security Reasoning: Authorizes user permission before minting temporary signed S3 URL.
     * Expired links prevent unauthorized link-sharing.
     */
    public function download(Request $request, int $documentId): JsonResponse
    {
        $document = Document::withoutGlobalScopes()->findOrFail($documentId);
        $this->authorize('view', $document);

        $url = $this->storageService->getTemporaryUrl($document->file_path, 15);

        AuditLog::create([
            'college_id' => $document->college_id,
            'user_id' => Auth::id(),
            'action' => 'document.download',
            'target_type' => Document::class,
            'target_id' => (string) $document->id,
            'ip_address' => $request->ip(),
            'details' => [
                'file_hash' => $document->file_hash,
            ],
        ]);

        return response()->json(['url' => $url]);
    }
}
