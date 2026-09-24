<?php

/**
 * ============================================================================
 * IQArchive v2 — Sample Common Documents Seeder
 * ============================================================================
 * File: database/seeders/SampleCommonDocumentSeeder.php
 * Responsibility: Generates sample institutional common document PDF entries
 *                 for HRDO and University Registrar offices with valid binary files
 *                 and audit logging.
 * Architecture: Database Seeder Layer
 * Security Context: Strictly carries null college_id and institutional category_id.
 * ============================================================================
 */

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SampleCommonDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Locate or create uploader (IQA Staff or first user)
        $uploader = User::whereHas('roles', fn ($q) => $q->where('name', 'iqa_staff'))->first()
            ?? User::where('email', 'iqastaff@example.com')->first()
            ?? User::first();

        if (! $uploader) {
            $uploader = User::create([
                'name' => 'IQA Staff Administrator',
                'email' => 'iqastaff@bicol-u.edu.ph',
                'status' => 'active',
            ]);
        }

        // 2. Fetch offices
        $hrdo = DocumentCategory::firstOrCreate(
            ['name' => 'HRDO', 'scope' => 'institutional'],
            ['description' => 'Human Resource Development Office: Plantilla, faculty rankings, appointment guidelines, and personnel welfare policies.']
        );

        $registrar = DocumentCategory::firstOrCreate(
            ['name' => 'University Registrar', 'scope' => 'institutional'],
            ['description' => 'Office of the University Registrar: Academic calendars, admission policies, grading circulars, and graduation statistics.']
        );

        $sampleEntries = [
            // HRDO Sample Documents
            [
                'office' => $hrdo,
                'title' => 'BU Faculty Merit Promotion Plan & Plantilla Guidelines (2025 Revised Edition)',
                'original_filename' => 'BU_HRDO_Faculty_Merit_Promotion_2025.pdf',
                'doc_number' => 'BU-HRDO-POL-2025-001',
                'status' => 'iqa_appr',
            ],
            [
                'office' => $hrdo,
                'title' => 'University Code of Conduct and Ethical Standards for Academic Personnel',
                'original_filename' => 'BU_HRDO_Code_of_Conduct_Policy.pdf',
                'doc_number' => 'BU-HRDO-POL-2024-008',
                'status' => 'draft',
            ],

            // University Registrar Sample Documents
            [
                'office' => $registrar,
                'title' => 'Official Academic Calendar & Enrollment Policies AY 2026-2027',
                'original_filename' => 'OUR_Academic_Calendar_AY2026_2027.pdf',
                'doc_number' => 'BU-OUR-CIR-2026-004',
                'status' => 'iqa_appr',
            ],
            [
                'office' => $registrar,
                'title' => 'University Retention, Grading System & Scholastic Delinquency Manual',
                'original_filename' => 'OUR_Retention_and_Grading_Manual.pdf',
                'doc_number' => 'BU-OUR-MAN-2025-002',
                'status' => 'dean_appr',
            ],
        ];

        $disk = config('filesystems.default', 'local');

        foreach ($sampleEntries as $entry) {
            $office = $entry['office'];
            $pdfContent = $this->buildPdfContent($entry['title'], $office->name, $entry['doc_number']);
            $fileHash = hash('sha256', $pdfContent);
            $fileSize = strlen($pdfContent);
            $filePath = "evidence/common/{$office->id}/{$fileHash}.pdf";

            // Store physical PDF file on storage disk
            Storage::disk($disk)->put($filePath, $pdfContent);

            // Also mirror to public disk if local environment has public storage
            if ($disk === 'local') {
                Storage::disk('public')->put($filePath, $pdfContent);
            }

            // Create or update Document record
            $document = Document::withoutGlobalScopes()->updateOrCreate(
                [
                    'category_id' => $office->id,
                    'title' => $entry['title'],
                ],
                [
                    'college_id' => null,
                    'program_id' => null,
                    'user_id' => $uploader->id,
                    'original_filename' => $entry['original_filename'],
                    'file_path' => $filePath,
                    'file_hash' => $fileHash,
                    'file_size_bytes' => $fileSize,
                    'mime_type' => 'application/pdf',
                    'status' => $entry['status'],
                    'visibility' => 'univ',
                ]
            );

            // Audit log entry
            AuditLog::firstOrCreate(
                [
                    'action' => 'document.upload.common',
                    'target_type' => Document::class,
                    'target_id' => (string) $document->id,
                ],
                [
                    'college_id' => null,
                    'user_id' => $uploader->id,
                    'ip_address' => '127.0.0.1',
                    'details' => [
                        'title' => $document->title,
                        'category_id' => $document->category_id,
                        'file_hash' => $document->file_hash,
                        'seeded' => true,
                    ],
                ]
            );
        }
    }

    /**
     * Build valid minimal PDF 1.4 binary content with accurate xref table.
     */
    private function buildPdfContent(string $title, string $officeName, string $docNumber): string
    {
        $date = date('F d, Y');
        $cleanTitle = addcslashes($title, "()\\");
        $cleanOffice = addcslashes($officeName, "()\\");
        $cleanDocNum = addcslashes($docNumber, "()\\");

        $body = "BT\n"
            . "/F1 16 Tf\n"
            . "50 730 Td\n"
            . "(BICOL UNIVERSITY) Tj\n"
            . "/F1 12 Tf\n"
            . "0 -24 Td\n"
            . "({$cleanOffice}) Tj\n"
            . "/F1 10 Tf\n"
            . "0 -20 Td\n"
            . "(Document Ref: {$cleanDocNum} | Date: {$date}) Tj\n"
            . "/F1 13 Tf\n"
            . "0 -35 Td\n"
            . "({$cleanTitle}) Tj\n"
            . "/F1 10 Tf\n"
            . "0 -30 Td\n"
            . "(Official document cataloged under institutional Common Documents vault.) Tj\n"
            . "0 -16 Td\n"
            . "(Certified true copy for AACCUP accreditation and quality assurance compliance.) Tj\n"
            . "ET\n";

        $bodyLen = strlen($body);

        $objects = [
            1 => "<< /Type /Catalog /Pages 2 0 R >>",
            2 => "<< /Type /Pages /Kids [3 0 R] /Count 1 >>",
            3 => "<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>",
            4 => "<< /Length {$bodyLen} >>\nstream\n{$body}endstream",
            5 => "<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>",
        ];

        $output = "%PDF-1.4\n";
        $offsets = [];

        foreach ($objects as $num => $obj) {
            $offsets[$num] = strlen($output);
            $output .= "{$num} 0 obj\n{$obj}\nendobj\n";
        }

        $xrefStart = strlen($output);
        $output .= "xref\n0 " . (count($objects) + 1) . "\n";
        $output .= "0000000000 65535 f \n";

        foreach ($offsets as $num => $offset) {
            $output .= sprintf("%010d 00000 n \n", $offset);
        }

        $output .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\n";
        $output .= "startxref\n{$xrefStart}\n%%EOF\n";

        return $output;
    }
}
