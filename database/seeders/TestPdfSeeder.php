<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\User;
use App\Models\AccreditationDocumentLink;
use App\Models\DocumentOcrValidation;
use App\Models\DocumentReview;
use App\Models\DocumentAccessRequest;
use App\Models\Notification;
use App\Models\Instrument;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TestPdfSeeder extends Seeder
{
    /**
     * Run the database seeds: Wipes storage/app/public/documents,
     * removes all current documents across the system, and generates 50 test PDF documents.
     */
    public function run(): void
    {
        $this->command?->info('Cleaning documents storage directory and database records...');

        // 1. Clean storage/app/public/documents directory completely
        $storageDir = storage_path('app/public/documents');
        if (File::exists($storageDir)) {
            File::cleanDirectory($storageDir);
        } else {
            File::makeDirectory($storageDir, 0755, true);
        }

        // 2. Clean all document records across the system
        AccreditationDocumentLink::query()->delete();
        DocumentOcrValidation::query()->delete();
        DocumentReview::query()->delete();
        DocumentAccessRequest::query()->delete();
        Notification::whereNotNull('related_document_id')->delete();
        Instrument::whereNotNull('document_id')->update(['document_id' => null]);
        Document::query()->delete();

        // 3. Retrieve system user for uploader
        $sysUser = User::where('email', 'sysadmin@example.com')->first() ?: User::first();
        if (!$sysUser) {
            $this->command?->error('No user found to assign documents to.');
            return;
        }

        // 4. Ensure categories exist
        $defaultCategories = [
            'Uncategorized Documents' => 'General and uncategorized institution documents.',
            'Policies & Issuances' => 'Administrative orders, memorandums, circulars, and university code documents.',
            'Instruments' => 'Internal QA self-evaluation spreadsheets, numerical rating guides, and diagnostic compliance evaluations.',
            'Memoranda' => 'Official office memorandums, notices of meetings, and executive directives.',
            'Correspondences' => 'Official letters to/from colleges, AACCUP, and administrative offices.',
            'Faculty Profile' => 'Faculty credentials, curriculum vitae, and loads.',
            'Curriculum / Syllabus' => 'Official course curriculum structure and syllabi.',
        ];

        foreach ($defaultCategories as $name => $desc) {
            DocumentCategory::firstOrCreate(
                ['name' => $name],
                ['description' => $desc]
            );
        }

        $categories = DocumentCategory::all();
        if ($categories->isEmpty()) {
            $this->command?->error('No document categories found.');
            return;
        }

        // 5. Generate 50 test PDF documents (test1.pdf to test50.pdf)
        $statuses = ['Verified', 'Verified', 'Pending', 'Rejected'];
        $offices = [
            'IQA Central Office',
            'Office of the President',
            'College of Science',
            'College of Engineering',
            'Office of the Vice President for Academic Affairs',
        ];

        for ($i = 1; $i <= 50; $i++) {
            $fileName = "test{$i}.pdf";
            $docTitle = "test{$i}";
            $category = $categories[($i - 1) % count($categories)];
            $relativeFilePath = "documents/{$fileName}";
            $fullPath = storage_path("app/public/{$relativeFilePath}");

            // Generate valid PDF content with Lorem Ipsum text
            $contentStr = "BT /F1 12 Tf 50 720 Td (Document: {$docTitle} - {$category->name}) Tj 0 -24 Td (Lorem ipsum dolor sit amet, consectetur adipiscing elit.) Tj 0 -18 Td (Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.) Tj 0 -18 Td (Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.) Tj 0 -18 Td (Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.) Tj 0 -24 Td (Bicol University Institutional Quality Assurance Center) Tj ET";
            $len = strlen($contentStr);

            $pdfContent = "%PDF-1.4\n";
            $pdfContent .= "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
            $pdfContent .= "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
            $pdfContent .= "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj\n";
            $pdfContent .= "4 0 obj\n<< /Length {$len} >>\nstream\n{$contentStr}\nendstream\nendobj\n";
            $pdfContent .= "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";
            $pdfContent .= "xref\n0 6\n0000000000 65535 f \n0000000009 00000 n \n0000000058 00000 n \n0000000115 00000 n \n0000000244 00000 n \n0000000495 00000 n \ntrailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n566\n%%EOF";

            File::put($fullPath, $pdfContent);

            $status = $statuses[($i - 1) % count($statuses)];
            $office = $offices[($i - 1) % count($offices)];

            Document::create([
                'title' => $docTitle,
                'uploaded_by' => $sysUser->id,
                'category_id' => $category->id,
                'file_path' => $relativeFilePath,
                'status' => $status,
                'visibility' => 'public',
                'created_at' => now()->subDays(50 - $i),
                'updated_at' => now()->subDays(50 - $i),
            ]);
        }

        $this->command?->info('Successfully wiped previous documents and generated 50 test PDF documents (test1.pdf - test50.pdf).');
    }
}
