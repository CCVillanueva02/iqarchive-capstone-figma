<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Office;
use Illuminate\Http\Request;

class DocumentCategoryController extends Controller
{
    /**
     * Get all offices for Common Documents.
     */
    public function getOffices()
    {
        $user = auth()->user();
        if (! $user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $userRole = $user->role;
        $isAllowed = in_array($userRole, ['iqa-staff', 'iqa-admin', 'iqa-member', 'task-force', 'task-force-member', 'college-head', 'system-administrator'])
            || $user->hasAnyRole(['iqa-staff', 'task-force-member', 'college-head', 'system-administrator']);

        if (! $isAllowed) {
            return response()->json(['error' => 'Unauthorized. Restricted role cannot access common documents.'], 403);
        }

        $offices = Office::all()->map(function ($office) {
            return [
                'id' => $office->id,
                'name' => $office->name,
                'description' => $office->description ?: 'Records for '.$office->name,
                'docCount' => Document::where('office_id', $office->id)->count(),
            ];
        });

        return response()->json($offices);
    }

    /**
     * Get all document categories with doc counts (including Uncategorized Documents) for a specific office.
     */
    public function index(Request $request)
    {
        $defaultCategories = [
            'Faculty profile' => 'Credentials, CVs, and loads.',
            'Curriculum / syllabus' => 'Course structure and syllabi.',
            'Policies & Issuances' => 'Administrative orders, memorandums, circulars, and university code documents.',
            'Instruments' => 'Internal QA self-evaluation spreadsheets, numerical rating guides, and diagnostic compliance evaluations.',
            'Memoranda' => 'Official office memorandums, notices of meetings, and executive directives.',
            'Correspondences' => 'Official letters to/from colleges, AACCUP, and administrative offices.',
            'Board Exam Performance' => 'Results and statistics of professional board examinations.',
            'Student Performance' => 'Student achievement and grades summaries.',
            'Uncategorized' => 'No documents yet.',
        ];

        foreach ($defaultCategories as $name => $desc) {
            DocumentCategory::firstOrCreate(
                ['name' => $name],
                ['description' => $desc]
            );
        }

        $user = auth()->user();
        if (! $user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $userRole = $user->role;
        $isAllowed = in_array($userRole, ['iqa-staff', 'iqa-admin', 'iqa-member', 'task-force', 'task-force-member', 'college-head', 'system-administrator'])
            || $user->hasAnyRole(['iqa-staff', 'task-force-member', 'college-head', 'system-administrator']);

        if (! $isAllowed) {
            return response()->json(['error' => 'Unauthorized. Restricted role cannot access common documents.'], 403);
        }

        $officeId = $request->query('office_id');
        $isIqaStaff = in_array($userRole, ['iqa-staff', 'iqa-admin', 'system-administrator']) || $user->hasAnyRole(['iqa-staff', 'system-administrator']);

        if ($isIqaStaff) {
            $categoriesQuery = DocumentCategory::withCount(['documents' => function ($q) use ($officeId) {
                if ($officeId) {
                    $q->where('office_id', $officeId);
                }
            }]);
        } else {
            // For other authorized roles: count ONLY verified documents
            $categoriesQuery = DocumentCategory::withCount(['documents' => function ($q) use ($officeId) {
                $q->where('status', 'Verified');
                if ($officeId) {
                    $q->where('office_id', $officeId);
                }
            }]);
        }

        $categories = $categoriesQuery->get()
            ->map(function ($cat) {
                $name = str_contains(strtolower($cat->name), 'uncategorized') ? 'Uncategorized' : $cat->name;
                $docCount = $cat->documents_count ?: 0;
                $description = $cat->description;

                if ($name === 'Uncategorized') {
                    if ($docCount > 0) {
                        $description = ($description && $description !== 'No documents yet.')
                            ? $description
                            : 'General and uncategorized institution documents.';
                    } else {
                        $description = 'No documents yet.';
                    }
                }

                return [
                    'id' => $cat->id,
                    'name' => $name,
                    'description' => $description ?: 'Common document category for '.$name,
                    'docCount' => $docCount,
                ];
            })
            ->sort(function ($a, $b) {
                $aIsUncat = str_contains(strtolower($a['name']), 'uncategorized');
                $bIsUncat = str_contains(strtolower($b['name']), 'uncategorized');
                if ($aIsUncat && ! $bIsUncat) {
                    return 1;
                }
                if (! $aIsUncat && $bIsUncat) {
                    return -1;
                }

                return 0;
            })
            ->values();

        return response()->json($categories);
    }

    /**
     * Create a new document category (Only for IQA Staff / Admin / System Admin).
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $isAllowed = in_array($user->role, ['iqa-staff', 'iqa-admin', 'system-administrator']) || $user->hasAnyRole(['iqa-staff', 'system-administrator']);

        if (! $isAllowed) {
            return response()->json(['error' => 'Unauthorized. Only IQA Staff can create new document categories.'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:document_categories,name',
            'description' => 'nullable|string|max:1000',
        ]);

        $category = DocumentCategory::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? 'Common document category for '.$validated['name'],
        ]);

        return response()->json([
            'message' => 'Document category created successfully.',
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'docCount' => 0,
            ],
        ], 201);
    }

    /**
     * Get all common documents filtered by user role permissions and office.
     */
    public function getDocuments(Request $request)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $userRole = $user->role;
        $isAllowed = in_array($userRole, ['iqa-staff', 'iqa-admin', 'iqa-member', 'task-force', 'task-force-member', 'college-head', 'system-administrator'])
            || $user->hasAnyRole(['iqa-staff', 'task-force-member', 'college-head', 'system-administrator']);

        if (! $isAllowed) {
            return response()->json(['error' => 'Unauthorized. Restricted role cannot view common documents.'], 403);
        }

        $isIqaAdmin = in_array($userRole, ['iqa-staff', 'iqa-admin', 'system-administrator']) || $user->hasAnyRole(['iqa-staff', 'system-administrator']);

        $query = Document::with(['category', 'uploader', 'office'])
            ->where(function ($q) {
                $q->whereNull('program_id')->orWhere('visibility', 'public');
            });

        if ($request->has('office_id')) {
            $query->where('office_id', $request->query('office_id'));
        }

        // Non-admin roles can ONLY see Verified documents OR documents they uploaded themselves
        if (! $isIqaAdmin) {
            $query->where(function ($q) use ($user) {
                $q->where('status', 'Verified')
                    ->orWhere('uploaded_by', $user->id);
            });
        }

        $documents = $query->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($doc) {
                $filePath = $doc->file_path ?: ('documents/'.$doc->title.'.pdf');
                $fileUrl = asset('storage/'.$filePath);

                return [
                    'id' => $doc->id,
                    'name' => $doc->title,
                    'category' => $doc->category ? $doc->category->name : 'Uncategorized Documents',
                    'type' => strtoupper(pathinfo($filePath, PATHINFO_EXTENSION)) ?: 'PDF',
                    'size' => '1.5 MB',
                    'date' => $doc->created_at ? $doc->created_at->format('Y-m-d') : now()->format('Y-m-d'),
                    'uploader' => $doc->uploader ? ($doc->uploader->first_name.' '.$doc->uploader->last_name) : 'IQA Office',
                    'uploaded_by_id' => $doc->uploaded_by,
                    'status' => $doc->status ?: 'Verified',
                    'file_path' => $filePath,
                    'file_url' => $fileUrl,
                    'ocrText' => 'Document Title: '.$doc->title."\nCategory: ".($doc->category ? $doc->category->name : 'Uncategorized Documents')."\nFile URL: ".$fileUrl,
                ];
            });

        return response()->json($documents);
    }

    /**
     * Store a new common document.
     * Documents uploaded by IQA Staff/Admin are automatically verified.
     * Documents uploaded by other staff/members default to Pending.
     */
    public function storeDocument(Request $request)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $userRole = $user->role;
        $isAllowed = in_array($userRole, ['iqa-staff', 'iqa-admin', 'iqa-member', 'task-force', 'task-force-member', 'college-head', 'system-administrator'])
            || $user->hasAnyRole(['iqa-staff', 'task-force-member', 'college-head', 'system-administrator']);

        if (! $isAllowed) {
            return response()->json(['error' => 'Unauthorized. Restricted role cannot upload common documents.'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_name' => 'nullable|string|max:255',
            'office_id' => 'required|exists:offices,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:25600',
        ]);

        // Default to Uncategorized Documents if category is empty/not provided
        $categoryName = ! empty($validated['category_name']) ? $validated['category_name'] : 'Uncategorized Documents';
        $category = DocumentCategory::firstOrCreate(
            ['name' => $categoryName],
            ['description' => 'General and uncategorized institution documents.']
        );

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            // Actual file uploaded
            $uploadedFile = $request->file('file');
            $filename = time().'_'.str_replace(' ', '_', $uploadedFile->getClientOriginalName());
            $relativeFilePath = $uploadedFile->storeAs('documents', $filename, 'public');
            $fileExtension = strtoupper($uploadedFile->getClientOriginalExtension());
            $fileSizeBytes = $uploadedFile->getSize();
            $fileSizeStr = round($fileSizeBytes / 1024 / 1024, 1).' MB';
        } else {
            // Generate test PDF file test[index].pdf
            $nextIndex = Document::count() + 1;
            $fileName = "test{$nextIndex}.pdf";
            $relativeFilePath = "documents/{$fileName}";
            $fullPath = storage_path("app/public/{$relativeFilePath}");
            $dir = dirname($fullPath);

            if (! file_exists($dir)) {
                mkdir($dir, 0755, true);
            }

            $docTitle = $validated['title'];
            $contentStr = "BT /F1 12 Tf 50 700 Td (Document: {$fileName} - {$docTitle}) Tj 0 -20 Td (Lorem ipsum dolor sit amet, consectetur adipiscing elit.) Tj 0 -20 Td (Bicol University Institutional Quality Assurance Office) Tj ET";
            $len = strlen($contentStr);

            $pdfContent = "%PDF-1.4\n";
            $pdfContent .= "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
            $pdfContent .= "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
            $pdfContent .= "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj\n";
            $pdfContent .= "4 0 obj\n<< /Length {$len} >>\nstream\n{$contentStr}\nendstream\nendobj\n";
            $pdfContent .= "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";
            $pdfContent .= "xref\n0 6\n0000000000 65535 f \n0000000009 00000 n \n0000000058 00000 n \n0000000115 00000 n \n0000000244 00000 n \n0000000495 00000 n \ntrailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n566\n%%EOF";

            file_put_contents($fullPath, $pdfContent);
            $fileExtension = 'PDF';
            $fileSizeStr = '1.8 MB';
        }

        $isIqaAdmin = in_array($user->role, ['iqa-staff', 'iqa-admin', 'system-administrator']) || $user->hasAnyRole(['iqa-staff', 'system-administrator']);
        $initialStatus = $isIqaAdmin ? 'Verified' : 'Pending';

        $doc = Document::create([
            'title' => $validated['title'],
            'category_id' => $category->id,
            'office_id' => $validated['office_id'],
            'uploaded_by' => $user->id,
            'confirmed_by' => $isIqaAdmin ? $user->id : null,
            'confirmed_at' => $isIqaAdmin ? now() : null,
            'file_path' => $relativeFilePath,
            'status' => $initialStatus,
            'visibility' => 'public',
        ]);

        $fileUrl = asset('storage/'.$relativeFilePath);

        return response()->json([
            'message' => $isIqaAdmin
                ? 'Document uploaded and automatically verified.'
                : 'Document uploaded successfully and is awaiting verification.',
            'document' => [
                'id' => $doc->id,
                'name' => $doc->title,
                'category' => $category->name,
                'size' => $fileSizeStr,
                'uploader' => $user->first_name.' '.$user->last_name,
                'uploaded_by_id' => $user->id,
                'date' => now()->format('Y-m-d'),
                'status' => $initialStatus,
                'type' => $fileExtension,
                'file_path' => $relativeFilePath,
                'file_url' => $fileUrl,
                'ocrText' => 'Document uploaded: '.$doc->title."\nCategory: ".$category->name."\nFile URL: ".$fileUrl,
            ],
        ], 201);
    }

    /**
     * Update common document status (Approve/Verify or Flag/Deny). Restricted to IQA Staff / System Admin.
     */
    public function updateStatus(Request $request, $id)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $isIqaStaff = in_array($user->role, ['iqa-staff', 'iqa-admin', 'system-administrator']) || $user->hasAnyRole(['iqa-staff', 'system-administrator']);

        if (! $isIqaStaff) {
            return response()->json(['error' => 'Unauthorized. Only IQA Staff can verify or flag common documents.'], 403);
        }

        $validated = $request->validate([
            'status' => 'required|string|in:Verified,Pending,Flagged,Rejected',
        ]);

        $doc = Document::findOrFail($id);
        $doc->status = $validated['status'];
        $doc->confirmed_by = $user->id;
        $doc->confirmed_at = now();
        $doc->save();

        return response()->json([
            'message' => 'Document status updated to '.$doc->status.'.',
            'status' => $doc->status,
            'document_id' => $doc->id,
        ]);
    }

    /**
     * Delete a document by ID — strictly allowed ONLY for IQA Staff / System Admin.
     */
    public function destroyDocument($id)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $isIqaStaff = in_array($user->role, ['iqa-staff', 'iqa-admin', 'system-administrator']) || $user->hasAnyRole(['iqa-staff', 'system-administrator']);

        if (! $isIqaStaff) {
            return response()->json(['error' => 'Unauthorized. Only IQA Staff can delete common documents.'], 403);
        }

        $doc = Document::findOrFail($id);

        if ($doc->file_path) {
            $fullPath = storage_path('app/public/'.$doc->file_path);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        $doc->delete();

        return response()->json(['message' => 'Document deleted successfully.']);
    }
}
