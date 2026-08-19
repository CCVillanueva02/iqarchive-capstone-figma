<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentReview;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    /**
     * Handle a new document submission from a Program Chair / College Head / Task Force / IQA Member.
     * Creates the Document record with status = 'pending' and logs the action.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            abort(401);
        }

        // Allowed roles for submission
        $allowedRoles = [
            'task-force-member',
            'iqa-staff',
            'college-head',
            'system-administrator',
        ];

        $isAllowed = in_array($user->role, $allowedRoles)
            || $user->hasRole('college-head')
            || $user->hasRole('task-force-member')
            || $user->hasRole('iqa-staff')
            || $user->hasRole('system-administrator')
            || $user->isTaskForceLead()
            || $user->isTaskForceMember();

        if (!$isAllowed) {
            abort(403, 'Unauthorized. Only authorized roles can submit documents.');
        }

        // Validate input
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'program_id'  => 'nullable|integer|exists:programs,id',
            'category_id' => 'required|integer|exists:document_categories,id',
            'description' => 'nullable|string|max:2000',
            'file'        => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:51200', // 50 MB
        ]);

        // Determine the program to attach
        $programId = $validated['program_id'] ?? $user->program_id;

        // Store the uploaded file in public/storage/documents/submissions
        $uploadedFile = $request->file('file');
        $filename     = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $uploadedFile->getClientOriginalName());
        $filePath     = $uploadedFile->storeAs('documents/submissions', $filename, 'public');

        // Create the Document record with pending status
        $document = Document::create([
            'title'       => $validated['title'],
            'uploaded_by' => $user->id,
            'program_id'  => $programId,
            'category_id' => $validated['category_id'],
            'file_path'   => $filePath,
            'status'      => 'pending',
            'visibility'  => 'private',
        ]);

        // Write to Audit Log
        AuditLog::create([
            'user_id'     => $user->id,
            'action'      => 'document_submitted',
            'target_type' => Document::class,
            'target_id'   => $document->id,
            'timestamp'   => now(),
        ]);

        // Resolve the correct submissions route for the user's role
        $roleSlug  = $user->role;
        $routeName = 'submissions.' . $roleSlug;
        if (! \Illuminate\Support\Facades\Route::has($routeName)) {
            $routeName = 'dashboard';
        }

        return redirect()
            ->route($routeName)
            ->with('success', '✅ Document "' . $document->title . '" submitted successfully! It is now in the IQA Review Queue as Pending.');
    }

    /**
     * Serve / View an uploaded document file inline in browser.
     */
    public function serveDocument($id)
    {
        $user = auth()->user();

        if (!$user) {
            abort(401);
        }

        $document = Document::findOrFail($id);

        if (!$document->file_path) {
            abort(404, 'File path not recorded for this document.');
        }

        // Check file on public disk
        if (Storage::disk('public')->exists($document->file_path)) {
            $fullPath = Storage::disk('public')->path($document->file_path);
            $mimeType = Storage::disk('public')->mimeType($document->file_path) ?? 'application/pdf';

            return response()->file($fullPath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . basename($document->file_path) . '"'
            ]);
        }

        // Also check direct storage_path
        $altPath = storage_path('app/public/' . $document->file_path);
        if (file_exists($altPath)) {
            $mimeType = mime_content_type($altPath) ?: 'application/pdf';
            return response()->file($altPath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . basename($altPath) . '"'
            ]);
        }

        abort(404, 'Document file not found on disk.');
    }

    /**
     * Review a document submission — Approve, Return, or Deny.
     * Accessible by IQA Member and IQA Admin only.
     * Mock (sample) document IDs (≤ 999) that don't exist in DB are silently redirected.
     */
    public function review(Request $request, $id)
    {
        $user = auth()->user();

        if (!$user) {
            abort(401);
        }

        $allowedReviewers = ['iqa-member', 'iqa-admin', 'system-administrator'];
        $isAllowed = in_array($user->role, $allowedReviewers)
            || $user->hasRole('iqa-member')
            || $user->hasRole('iqa-admin')
            || $user->hasRole('system-administrator');

        if (!$isAllowed) {
            abort(403, 'Unauthorized. Only IQA Staff and Administrators can review document submissions.');
        }

        // Guard: if the document doesn't exist (e.g. a sample/mock doc), redirect gracefully
        $document = Document::find($id);
        if (! $document) {
            return back()->with('info', 'This is a sample document used for demonstration. Submit a real document to enable review actions.');
        }

        $validated = $request->validate([
            'decision' => 'required|string|in:approved,returned,denied',
            'remarks'  => 'nullable|string|max:1000',
        ]);

        // Update document status
        $document->status       = $validated['decision'];
        $document->confirmed_by = $user->id;
        $document->confirmed_at = now();
        $document->save();

        // Create review record
        DocumentReview::create([
            'document_id' => $document->id,
            'reviewed_by' => $user->id,
            'decision'    => $validated['decision'],
            'remarks'     => $validated['remarks'] ?? 'No remarks provided.',
            'reviewed_at' => now(),
        ]);

        // Audit Log
        AuditLog::create([
            'user_id'     => $user->id,
            'action'      => 'document_' . $validated['decision'],
            'target_type' => Document::class,
            'target_id'   => $document->id,
            'timestamp'   => now(),
        ]);

        $statusLabel = match($validated['decision']) {
            'approved' => 'Approved ✅',
            'returned' => 'Returned for Revision ↩️',
            'denied'   => 'Denied ❌',
            default    => ucfirst($validated['decision'])
        };

        return back()->with('success', 'Document "' . $document->title . '" has been marked as ' . $statusLabel . '. The submitter will see this update immediately.');
    }
}
