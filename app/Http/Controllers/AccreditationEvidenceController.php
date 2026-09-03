<?php

namespace App\Http\Controllers;

use App\Models\Accreditation;
use App\Models\AccreditationDocumentLink;
use App\Models\AuditLog;
use App\Models\ComplianceRequirement;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Instrument;
use App\Models\InstrumentCriterion;
use App\Models\Notification;
use App\Models\Program;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AccreditationEvidenceController extends Controller
{
    /**
     * Upload an evidence file and link it to an accreditation criterion/compliance requirement.
     * Security Reasoning: Enforces role checks and verifies that the accreditation instrument
     * has been finalized by the Dean before accepting Task Force uploads.
     */
    public function upload(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (! $user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,png,zip|max:51200', // 50MB
            'program_id' => 'required|exists:programs,id',
            'accreditation_id' => 'nullable|exists:accreditations,id',
            'instrument_criterion_id' => 'nullable|integer',
            'criterion_code' => 'nullable|string|max:50',
            'area_code' => 'nullable|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'tags' => 'nullable',
        ]);

        $program = Program::with('college')->findOrFail($validated['program_id']);

        // Check if user is authorized to upload for this program
        $isUnrestricted = $user->hasAnyRole(['iqa-staff', 'iqa-admin', 'system-administrator']) ||
                          in_array($user->role, ['iqa-staff', 'iqa-admin', 'system-administrator']);

        if (! $isUnrestricted) {
            if ($user->hasRole('college-head') || $user->role === 'college-head') {
                if ($user->college_id && $program->college_id !== $user->college_id) {
                    return response()->json(['error' => 'Unauthorized for this college program.'], 403);
                }
            } elseif ($user->hasRole('task-force-member') || $user->role === 'task-force-member') {
                // Task force member must be assigned to this program/college
                $isAssigned = ($user->program_id === $program->id) ||
                              ($user->college_id === $program->college_id) ||
                              $user->taskForces()->where('program_id', $program->id)->exists();

                if (! $isAssigned) {
                    return response()->json(['error' => 'Unauthorized. You are not a member of this program Task Force.'], 403);
                }

                // Check instrument verification status for Task Force uploads
                $accreditation = isset($validated['accreditation_id'])
                    ? Accreditation::find($validated['accreditation_id'])
                    : $program->accreditations()->latest()->first();

                if ($accreditation) {
                    $allowedStatuses = ['document_preparation', 'uploading', 'dean_verification', 'submitted', 'completed'];
                    if (! in_array($accreditation->status, $allowedStatuses)) {
                        return response()->json([
                            'error' => 'Uploads are locked. The College Dean has not yet verified the accreditation instrument for this program.',
                            'accreditation_status' => $accreditation->status,
                        ], 403);
                    }
                }
            }
        }

        // Store file on public disk under evidence/{program_id}
        $uploadedFile = $request->file('file');
        $fileName = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $uploadedFile->getClientOriginalName());
        $filePath = $uploadedFile->storeAs("documents/evidence/{$program->id}", $fileName, 'public');

        // Resolve or create category for Accreditation Supporting Evidence
        $category = DocumentCategory::firstOrCreate(
            ['name' => 'Supporting Documents'],
            ['description' => 'AACCUP parameter criteria evidence files, policies, and supporting artifacts.']
        );

        // Create Document record
        $document = Document::create([
            'title' => $validated['title'],
            'file_path' => $filePath,
            'uploaded_by' => $user->id,
            'program_id' => $program->id,
            'category_id' => $category->id,
            'status' => 'pending',
            'visibility' => 'private',
        ]);

        // Resolve Accreditation
        $accreditationId = $validated['accreditation_id'] ?? $program->accreditations()->latest()->value('id');

        // Resolve or create Compliance Requirement
        $criterionId = $validated['instrument_criterion_id'] ?? null;
        if (! $criterionId && ! empty($validated['criterion_code'])) {
            $criterionQuery = InstrumentCriterion::where('code', $validated['criterion_code']);
            if (! empty($validated['area_code'])) {
                $criterionQuery->whereHas('parameter.area', function ($q) use ($validated) {
                    $q->where('name', $validated['area_code'])->orWhere('code', $validated['area_code']);
                });
            }
            $criterion = $criterionQuery->first();
            if (! $criterion) {
                $criterion = InstrumentCriterion::where('code', $validated['criterion_code'])->first();
            }
            $criterionId = $criterion?->id;
        }

        $complianceRequirement = null;
        if ($criterionId && $accreditationId) {
            $complianceRequirement = ComplianceRequirement::where('accreditation_id', $accreditationId)
                ->where('instrument_criterion_id', $criterionId)
                ->first();
        } elseif ($criterionId) {
            $complianceRequirement = ComplianceRequirement::where('instrument_criterion_id', $criterionId)->first();
        }

        if (! $complianceRequirement) {
            $resolvedInstrumentId = null;
            if ($criterionId) {
                $crit = InstrumentCriterion::with('parameter.area')->find($criterionId);
                $resolvedInstrumentId = $crit?->parameter?->area?->instrument_id;
            }
            if (! $resolvedInstrumentId && $accreditationId) {
                $resolvedInstrumentId = Instrument::where('accreditation_id', $accreditationId)->value('id');
            }
            if (! $resolvedInstrumentId) {
                $resolvedInstrumentId = Instrument::where('program_id', $program->id)->value('id')
                    ?? Instrument::where('is_template', true)->value('id')
                    ?? Instrument::value('id');
            }

            if ($resolvedInstrumentId) {
                $critCode = $validated['criterion_code'] ?? ($criterion?->code ?? '');
                $areaCode = $validated['area_code'] ?? ($criterion?->parameter?->area?->name ?? ($criterion?->parameter?->area?->code ?? ''));
                $paramCode = $validated['parameter_code'] ?? ($criterion?->parameter?->name ?? ($criterion?->parameter?->code ?? ''));

                $descParts = [];
                if ($areaCode) {
                    $descParts[] = "[Area: {$areaCode}]";
                }
                if ($paramCode) {
                    $descParts[] = "[Parameter: {$paramCode}]";
                }
                if ($critCode) {
                    $descParts[] = "[Criterion: {$critCode}]";
                }
                $prefix = implode(' ', $descParts);

                $complianceRequirement = ComplianceRequirement::create([
                    'instrument_id' => $resolvedInstrumentId,
                    'accreditation_id' => $accreditationId,
                    'program_id' => $program->id,
                    'instrument_criterion_id' => $criterionId,
                    'description' => trim("{$prefix} ".($validated['description'] ?? ($validated['title'] ?? 'Accreditation Evidence'))),
                    'status' => 'pending',
                ]);
            }
        }

        // Link Document to Compliance Requirement (M:N mapping)
        if ($complianceRequirement) {
            AccreditationDocumentLink::firstOrCreate([
                'document_id' => $document->id,
                'compliance_requirement_id' => $complianceRequirement->id,
            ]);
        }

        // Audit Logging (Explicit Security & Traceability Requirement)
        $criterionLabel = $validated['criterion_code'] ?? 'General Parameter';
        AuditLog::create([
            'user_id' => $user->id,
            'action' => "Task Force member uploaded evidence document '{$document->title}' for criterion {$criterionLabel} in {$program->name}",
            'target_type' => 'Document',
            'target_id' => $document->id,
            'timestamp' => now(),
        ]);

        $fileSizeFormatted = $uploadedFile->getSize() ? round($uploadedFile->getSize() / 1048576, 2).' MB' : '1.0 MB';

        return response()->json([
            'message' => 'Evidence document uploaded and linked successfully.',
            'document' => [
                'id' => $document->id,
                'name' => $document->title,
                'fileName' => basename($filePath),
                'type' => strtoupper($uploadedFile->getClientOriginalExtension()),
                'size' => $fileSizeFormatted,
                'date' => now()->format('Y-m-d'),
                'uploader' => $user->name,
                'office' => $program->college ? $program->college->name : 'BU College',
                'status' => 'Pending',
                'criterion_code' => $validated['criterion_code'] ?? null,
                'criterion_id' => $criterionId,
                'file_url' => Storage::url($filePath),
            ],
        ], 201);
    }

    /**
     * Get all uploaded evidence documents for a given program.
     */
    public function getProgramEvidence(Request $request, $programId)
    {
        $program = Program::with('college')->findOrFail($programId);

        $documents = Document::with(['uploader', 'accreditationLinks.complianceRequirement.criterion.parameter.area'])
            ->where('program_id', $program->id)
            ->latest()
            ->get();

        $data = $documents->map(function ($doc) {
            $link = $doc->accreditationLinks->first();
            $req = $link?->complianceRequirement;
            $criterion = $req?->criterion;

            $criterionCode = $criterion?->code;
            if (! $criterionCode && $req && preg_match('/\[Criterion:\s*([^\]]+)\]/', $req->description, $matches)) {
                $criterionCode = trim($matches[1]);
            }

            $areaCode = $criterion?->parameter?->area?->name ?? $criterion?->parameter?->area?->code;
            if (! $areaCode && $req && preg_match('/\[Area:\s*([^\]]+)\]/', $req->description, $matches)) {
                $areaCode = trim($matches[1]);
            }

            $paramCode = $criterion?->parameter?->name ?? $criterion?->parameter?->code;
            if (! $paramCode && $req && preg_match('/\[Parameter:\s*([^\]]+)\]/', $req->description, $matches)) {
                $paramCode = trim($matches[1]);
            }

            $fileSizeFormatted = '1.0 MB';
            if ($doc->file_path && Storage::disk('public')->exists($doc->file_path)) {
                $bytes = Storage::disk('public')->size($doc->file_path);
                $fileSizeFormatted = $bytes ? round($bytes / 1048576, 2).' MB' : '1.0 MB';
            }

            return [
                'id' => $doc->id,
                'name' => $doc->title,
                'fileName' => basename($doc->file_path),
                'type' => strtoupper(pathinfo($doc->file_path, PATHINFO_EXTENSION)),
                'size' => $fileSizeFormatted,
                'date' => $doc->created_at ? $doc->created_at->format('Y-m-d') : now()->format('Y-m-d'),
                'uploader' => $doc->uploader ? $doc->uploader->name : 'Task Force Member',
                'office' => $doc->program?->college?->name ?? 'BU College',
                'status' => ucfirst($doc->status ?? 'pending'),
                'area_code' => $areaCode,
                'parameter_code' => $paramCode,
                'criterion_code' => $criterionCode,
                'criterion_id' => $criterion?->id ?? $req?->instrument_criterion_id,
                'file_url' => $doc->file_path ? Storage::url($doc->file_path) : null,
            ];
        });

        return response()->json($data);
    }

    /**
     * Submit evidence repository to the College Dean for verification (Step 5.3).
     * Security Reasoning: Transitions accreditation status to dean_verification,
     * alerts the Dean via in-app notification, and records an immutable audit log.
     */
    public function submitToDean(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (! $user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'accreditation_id' => 'nullable|exists:accreditations,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $program = Program::with('college')->findOrFail($validated['program_id']);

        $accreditation = isset($validated['accreditation_id'])
            ? Accreditation::find($validated['accreditation_id'])
            : $program->accreditations()->latest()->first();

        if (! $accreditation) {
            return response()->json(['error' => 'No active accreditation cycle found for this program.'], 404);
        }

        // Advance accreditation status to dean_verification
        $accreditation->update([
            'status' => 'dean_verification',
        ]);

        // Notify College Dean(s)
        $deanRole = Role::where('role_name', 'college-head')->first();
        if ($deanRole && $program->college_id) {
            $deans = User::where(function ($q) use ($deanRole) {
                $q->where('role_id', $deanRole->id)
                    ->orWhereHas('roles', fn ($rq) => $rq->where('role_name', 'college-head'));
            })->where('college_id', $program->college_id)->get();

            foreach ($deans as $dean) {
                Notification::create([
                    'user_id' => $dean->id,
                    'type' => 'action_required',
                    'message' => "The Task Force for {$program->name} has submitted their accreditation evidence files for your verification and sign-off.",
                    'is_read' => false,
                ]);
            }
        }

        // Write AuditLog
        AuditLog::create([
            'user_id' => $user->id,
            'action' => "Task Force submitted accreditation evidence documents for {$program->name} to College Dean for verification.",
            'target_type' => 'Accreditation',
            'target_id' => $accreditation->id,
            'timestamp' => now(),
        ]);

        return response()->json([
            'message' => "Accreditation evidence for {$program->name} submitted to College Dean successfully.",
            'accreditation_status' => 'dean_verification',
        ]);
    }
}
