<?php

namespace App\Http\Controllers;

use App\Models\DocumentCategory;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentCategoryController extends Controller
{
    /**
     * Get all document categories with doc counts (including Uncategorized Documents).
     */
    public function index()
    {
        // Ensure default Uncategorized Documents category exists in database
        DocumentCategory::firstOrCreate(
            ['name' => 'Uncategorized Documents'],
            ['description' => 'General and uncategorized institution documents.']
        );

        $categories = DocumentCategory::withCount('documents')
            ->get()
            ->map(function ($cat) {
                return [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'description' => $cat->description ?: 'Common document category for ' . $cat->name,
                    'docCount' => $cat->documents_count ?: 0,
                ];
            });

        return response()->json($categories);
    }

    /**
     * Create a new document category (Only for IQA Admin and System Admin).
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        // Strictly allow IQA Admin and System Administrator only
        $isAllowed = $user->hasRole('iqa-admin') || 
                     $user->hasRole('system-administrator') || 
                     in_array($user->role, ['iqa-admin', 'system-administrator']);

        if (!$isAllowed) {
            return response()->json(['error' => 'Unauthorized. Only IQA Admin and System Administrator can create new document categories.'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:document_categories,name',
            'description' => 'nullable|string|max:1000',
        ]);

        $category = DocumentCategory::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? 'Common document category for ' . $validated['name'],
        ]);

        return response()->json([
            'message' => 'Document category created successfully.',
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'docCount' => 0,
            ]
        ], 201);
    }

    /**
     * Get all common documents.
     */
    public function getDocuments()
    {
        $documents = Document::with(['category', 'uploader'])
            ->whereNull('program_id')
            ->orWhere('visibility', 'public')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($doc) {
                $filePath = $doc->file_path ?: ('documents/' . $doc->title . '.pdf');
                $fileUrl = route('documents.serve', ['id' => $doc->id]);

                return [
                    'id' => $doc->id,
                    'name' => $doc->title,
                    'category' => $doc->category ? $doc->category->name : 'Uncategorized Documents',
                    'type' => strtoupper(pathinfo($filePath, PATHINFO_EXTENSION)) ?: 'PDF',
                    'size' => '1.5 MB',
                    'date' => $doc->created_at ? $doc->created_at->format('Y-m-d') : now()->format('Y-m-d'),
                    'uploader' => $doc->uploader ? ($doc->uploader->first_name . ' ' . $doc->uploader->last_name) : 'IQA Office',
                    'status' => $doc->status ?: 'Verified',
                    'file_path' => $filePath,
                    'file_url' => $fileUrl,
                    'ocrText' => 'Document Title: ' . $doc->title . "\nCategory: " . ($doc->category ? $doc->category->name : 'Uncategorized Documents') . "\nFile URL: " . $fileUrl,
                ];
            });

        return response()->json($documents);
    }

    /**
     * Store a new common document.
     * Category is optional; defaults to 'Uncategorized Documents' if omitted or empty.
     * Supports actual file uploads via multipart request or falls back to generated PDF.
     */
    public function storeDocument(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $allowedRoles = ['iqa-admin', 'iqa-member', 'system-administrator'];
        $isAllowed = in_array($user->role, $allowedRoles) || $user->hasRole('iqa-admin') || $user->hasRole('iqa-member') || $user->hasRole('system-administrator');

        if (!$isAllowed) {
            return response()->json(['error' => 'Unauthorized. Only IQA Admin, IQA Member, and System Admin can upload common documents.'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_name' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:25600',
        ]);

        // Default to Uncategorized Documents if category is empty/not provided
        $categoryName = !empty($validated['category_name']) ? $validated['category_name'] : 'Uncategorized Documents';
        $category = DocumentCategory::firstOrCreate(
            ['name' => $categoryName],
            ['description' => 'General and uncategorized institution documents.']
        );

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            // Actual file uploaded
            $uploadedFile = $request->file('file');
            $filename = time() . '_' . str_replace(' ', '_', $uploadedFile->getClientOriginalName());
            $relativeFilePath = $uploadedFile->storeAs('documents', $filename, 'public');
            $fileExtension = strtoupper($uploadedFile->getClientOriginalExtension());
            $fileSizeBytes = $uploadedFile->getSize();
            $fileSizeStr = round($fileSizeBytes / 1024 / 1024, 1) . ' MB';
        } else {
            // Generate test PDF file test[index].pdf
            $nextIndex = Document::count() + 1;
            $fileName = "test{$nextIndex}.pdf";
            $relativeFilePath = "documents/{$fileName}";
            $fullPath = storage_path("app/public/{$relativeFilePath}");
            $dir = dirname($fullPath);

            if (!file_exists($dir)) {
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

        $doc = Document::create([
            'title' => $validated['title'],
            'category_id' => $category->id,
            'uploaded_by' => $user->id,
            'file_path' => $relativeFilePath,
            'status' => 'Pending',
            'visibility' => 'public',
        ]);

        $fileUrl = route('documents.serve', ['id' => $doc->id]);

        return response()->json([
            'message' => 'Document uploaded successfully.',
            'document' => [
                'id' => $doc->id,
                'name' => $doc->title,
                'category' => $category->name,
                'size' => $fileSizeStr,
                'uploader' => $user->first_name . ' ' . $user->last_name,
                'date' => now()->format('Y-m-d'),
                'status' => 'Pending',
                'type' => $fileExtension,
                'file_path' => $relativeFilePath,
                'file_url' => $fileUrl,
                'ocrText' => 'Document uploaded: ' . $doc->title . "\nCategory: " . $category->name . "\nFile URL: " . $fileUrl,
            ]
        ], 201);
    }
}
