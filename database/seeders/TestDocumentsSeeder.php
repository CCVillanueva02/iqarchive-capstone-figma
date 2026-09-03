<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestDocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sysUser = User::where('email', 'sysadmin@example.com')->first() ?: User::first();

        if (! $sysUser) {
            $this->command->error('No user found to assign documents to.');

            return;
        }

        $categoriesToSeedDocs = [
            'Policies & Issuances' => 'Bicol University Governance & Academic Policy 2026',
            'Instruments' => 'Level IV QA Self Evaluation Instrument',
            'Memoranda' => 'Quality Assurance Audit Memorandum 2026-042',
            'Correspondences' => 'AACCUP Official Certificate & Endorsement Letter',
            'Uncategorized Documents' => 'General Institutional QA Manual & Operational Guidelines',
        ];

        $index = 1;
        foreach ($categoriesToSeedDocs as $catName => $docTitle) {
            $category = DocumentCategory::firstOrCreate(
                ['name' => $catName],
                ['description' => 'General documents for '.$catName]
            );

            $fileName = "test{$index}.pdf";
            $relativeFilePath = "documents/{$fileName}";
            $fullPath = storage_path("app/public/{$relativeFilePath}");
            $dir = dirname($fullPath);

            if (! file_exists($dir)) {
                mkdir($dir, 0755, true);
            }

            $contentStr = "BT /F1 12 Tf 50 700 Td (Document: {$fileName} - {$docTitle}) Tj 0 -20 Td (Lorem ipsum dolor sit amet, consectetur adipiscing elit.) Tj 0 -20 Td (Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.) Tj 0 -20 Td (Bicol University Institutional Quality Assurance Office) Tj ET";
            $len = strlen($contentStr);

            $pdfContent = "%PDF-1.4\n";
            $pdfContent .= "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
            $pdfContent .= "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
            $pdfContent .= "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj\n";
            $pdfContent .= "4 0 obj\n<< /Length {$len} >>\nstream\n{$contentStr}\nendstream\nendobj\n";
            $pdfContent .= "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";
            $pdfContent .= "xref\n0 6\n0000000000 65535 f \n0000000009 00000 n \n0000000058 00000 n \n0000000115 00000 n \n0000000244 00000 n \n0000000495 00000 n \ntrailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n566\n%%EOF";

            file_put_contents($fullPath, $pdfContent);

            Document::firstOrCreate(
                [
                    'title' => "test{$index}",
                ],
                [
                    'uploaded_by' => $sysUser->id,
                    'category_id' => $category->id,
                    'file_path' => $relativeFilePath,
                    'status' => 'approved',
                    'visibility' => 'public',
                ]
            );

            $index++;
        }
    }
}
