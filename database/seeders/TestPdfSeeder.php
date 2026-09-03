<?php

namespace Database\Seeders;

use App\Models\AccreditationDocumentLink;
use App\Models\Document;
use App\Models\DocumentAccessRequest;
use App\Models\DocumentCategory;
use App\Models\DocumentOcrValidation;
use App\Models\DocumentReview;
use App\Models\Instrument;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TestPdfSeeder extends Seeder
{
    /**
     * Run the database seeds: Wipes storage/app/public/documents,
     * removes all generic test documents, and generates realistic institutional QA PDF documents.
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

        // 2. Clean previous document records across the system
        AccreditationDocumentLink::query()->delete();
        DocumentOcrValidation::query()->delete();
        DocumentReview::query()->delete();
        DocumentAccessRequest::query()->delete();
        Notification::whereNotNull('related_document_id')->delete();
        Instrument::whereNotNull('document_id')->update(['document_id' => null]);
        Document::query()->delete();

        // 3. Retrieve system user for uploader
        $sysUser = User::where('email', 'sysadmin@example.com')->first() ?: User::first();
        if (! $sysUser) {
            $this->command?->error('No user found to assign documents to.');

            return;
        }

        // 4. Ensure standard categories exist
        $defaultCategories = [
            'Policies & Issuances' => 'Administrative orders, memorandums, circulars, and university code documents.',
            'Curriculum / Syllabus' => 'Official course curriculum structure and syllabi.',
            'Faculty Profile' => 'Faculty credentials, curriculum vitae, and loads.',
            'Instruments' => 'Internal QA self-evaluation spreadsheets, numerical rating guides, and diagnostic compliance evaluations.',
            'Memoranda' => 'Official office memorandums, notices of meetings, and executive directives.',
            'Correspondences' => 'Official letters to/from colleges, AACCUP, and administrative offices.',
            'Uncategorized Documents' => 'General and uncategorized institutional QA documents.',
        ];

        foreach ($defaultCategories as $name => $desc) {
            DocumentCategory::firstOrCreate(
                ['name' => $name],
                ['description' => $desc]
            );
        }

        // 5. Realistic Institutional QA Documents Definition
        $qaDocuments = [
            [
                'fileName' => 'BOR_Resolution_Approving_University_VMGO_2026.pdf',
                'title' => 'BOR Resolution Approving University VMGO',
                'category' => 'Policies & Issuances',
                'status' => 'Verified',
                'office' => 'Office of the University Secretary',
            ],
            [
                'fileName' => 'Bicol_University_Strategic_Development_Plan_2024_2028.pdf',
                'title' => 'Bicol University Strategic Development Plan 2024-2028',
                'category' => 'Policies & Issuances',
                'status' => 'Verified',
                'office' => 'Planning and Development Office',
            ],
            [
                'fileName' => 'Faculty_Plantilla_and_Merit_Promotion_Manual.pdf',
                'title' => 'Faculty Plantilla and Merit Promotion Manual',
                'category' => 'Faculty Profile',
                'status' => 'Verified',
                'office' => 'Human Resource Management Division',
            ],
            [
                'fileName' => 'BSCS_Curriculum_Map_and_OBE_Framework.pdf',
                'title' => 'BSCS Curriculum Map and OBE Framework',
                'category' => 'Curriculum / Syllabus',
                'status' => 'Verified',
                'office' => 'College of Science - Computer Science Dept',
            ],
            [
                'fileName' => 'Student_Handbook_and_Code_of_Discipline_Rev2025.pdf',
                'title' => 'Student Handbook and Code of Discipline',
                'category' => 'Policies & Issuances',
                'status' => 'Verified',
                'office' => 'Office of Student Affairs and Services',
            ],
            [
                'fileName' => 'Institutional_Research_Agenda_and_Ethics_Manual.pdf',
                'title' => 'Institutional Research Agenda & Ethics Manual',
                'category' => 'Policies & Issuances',
                'status' => 'Verified',
                'office' => 'Research and Development Center',
            ],
            [
                'fileName' => 'Extension_Community_Engagement_Guidelines_and_MOUs.pdf',
                'title' => 'Extension Community Engagement Guidelines and MOUs',
                'category' => 'Correspondences',
                'status' => 'Verified',
                'office' => 'Extension Management Division',
            ],
            [
                'fileName' => 'Library_Holdings_and_E_Resource_Subscriptions_Audit.pdf',
                'title' => 'Library Holdings & E-Resource Subscriptions Audit',
                'category' => 'Instruments',
                'status' => 'Verified',
                'office' => 'University Library Services',
            ],
            [
                'fileName' => 'Laboratory_Safety_and_Chemical_Management_Manual.pdf',
                'title' => 'Laboratory Safety and Chemical Management Manual',
                'category' => 'Policies & Issuances',
                'status' => 'Verified',
                'office' => 'Physical Plant and Laboratory Management',
            ],
            [
                'fileName' => 'Physical_Facilities_and_Disaster_Mitigation_Plan.pdf',
                'title' => 'Physical Facilities & Disaster Mitigation Plan',
                'category' => 'Policies & Issuances',
                'status' => 'Verified',
                'office' => 'General Services and Facilities Office',
            ],
            [
                'fileName' => 'Administrative_Support_Staff_Competency_Framework.pdf',
                'title' => 'Administrative Support Staff Competency Framework',
                'category' => 'Policies & Issuances',
                'status' => 'Verified',
                'office' => 'Human Resource Management Division',
            ],
            [
                'fileName' => 'AACCUP_Accreditation_Executive_Summary_Report.pdf',
                'title' => 'AACCUP Accreditation Executive Summary Report',
                'category' => 'Correspondences',
                'status' => 'Verified',
                'office' => 'Institutional Quality Assurance Center',
            ],
            [
                'fileName' => 'Faculty_Development_Program_and_Scholarship_Grants.pdf',
                'title' => 'Faculty Development Program & Scholarship Grants',
                'category' => 'Faculty Profile',
                'status' => 'Verified',
                'office' => 'Office of the Vice President for Academic Affairs',
            ],
            [
                'fileName' => 'OBTL_Course_Syllabi_Compendium_Volume_I.pdf',
                'title' => 'OBTL Course Syllabi Compendium Volume I',
                'category' => 'Curriculum / Syllabus',
                'status' => 'Verified',
                'office' => 'College of Science - Computer Science Dept',
            ],
            [
                'fileName' => 'Graduate_Tracer_Study_and_Employability_Assessment.pdf',
                'title' => 'Graduate Tracer Study & Employability Assessment',
                'category' => 'Instruments',
                'status' => 'Verified',
                'office' => 'Alumni Relations and Placement Office',
            ],
            [
                'fileName' => 'IQA_Internal_Quality_Audit_Annual_Report_2026.pdf',
                'title' => 'IQA Internal Quality Audit Annual Report 2026',
                'category' => 'Instruments',
                'status' => 'Verified',
                'office' => 'Institutional Quality Assurance Center',
            ],
            [
                'fileName' => 'Community_Extension_Impact_Assessment_Study.pdf',
                'title' => 'Community Extension Impact Assessment Study',
                'category' => 'Correspondences',
                'status' => 'Verified',
                'office' => 'Extension Management Division',
            ],
            [
                'fileName' => 'Financial_Audit_and_Capital_Expenditure_Report.pdf',
                'title' => 'Financial Audit & Capital Expenditure Report',
                'category' => 'Policies & Issuances',
                'status' => 'Verified',
                'office' => 'Budget and Financial Management Office',
            ],
            [
                'fileName' => 'Campus_IT_Infrastructure_and_Cybersecurity_Policy.pdf',
                'title' => 'Campus IT Infrastructure & Cybersecurity Policy',
                'category' => 'Policies & Issuances',
                'status' => 'Verified',
                'office' => 'Information and Communications Technology Center',
            ],
            [
                'fileName' => 'Student_Scholarship_and_Grant_In_Aid_Registry.pdf',
                'title' => 'Student Scholarship & Grant-In-Aid Registry',
                'category' => 'Memoranda',
                'status' => 'Verified',
                'office' => 'Office of Student Affairs and Services',
            ],
            [
                'fileName' => 'Guidance_and_Psychological_Services_Annual_Report.pdf',
                'title' => 'Guidance & Psychological Services Annual Report',
                'category' => 'Instruments',
                'status' => 'Verified',
                'office' => 'University Guidance and Testing Center',
            ],
            [
                'fileName' => 'Industry_Advisory_Board_Curriculum_Review_Minutes.pdf',
                'title' => 'Industry Advisory Board Curriculum Review Minutes',
                'category' => 'Memoranda',
                'status' => 'Verified',
                'office' => 'College of Science - Computer Science Dept',
            ],
            [
                'fileName' => 'Practicum_Internship_Manual_and_Partner_MOAs.pdf',
                'title' => 'Practicum Internship Manual & Partner MOAs',
                'category' => 'Correspondences',
                'status' => 'Verified',
                'office' => 'College of Science - Internship Office',
            ],
            [
                'fileName' => 'Environmental_Health_and_Safety_Audit_Report.pdf',
                'title' => 'Environmental Health & Safety Audit Report',
                'category' => 'Instruments',
                'status' => 'Verified',
                'office' => 'Pollution Control and Safety Office',
            ],
            [
                'fileName' => 'ISO_9001_Quality_Management_System_Procedures.pdf',
                'title' => 'ISO 9001 Quality Management System Procedures',
                'category' => 'Policies & Issuances',
                'status' => 'Verified',
                'office' => 'Institutional Quality Assurance Center',
            ],
        ];

        foreach ($qaDocuments as $index => $item) {
            $fileName = $item['fileName'];
            $docTitle = $item['title'];
            $categoryName = $item['category'];
            $status = $item['status'];

            $category = DocumentCategory::firstOrCreate(
                ['name' => $categoryName],
                ['description' => 'Institutional QA documents for '.$categoryName]
            );

            $relativeFilePath = "documents/{$fileName}";
            $fullPath = storage_path("app/public/{$relativeFilePath}");

            // Generate valid, printable PDF file
            $contentStr = "BT /F1 12 Tf 50 720 Td (Document: {$docTitle}) Tj 0 -24 Td (Category: {$categoryName}) Tj 0 -18 Td (Issuing Office: {$item['office']}) Tj 0 -24 Td (Bicol University Institutional Quality Assurance Center) Tj 0 -18 Td (This document serves as verified institutional evidence for accreditation compliance.) Tj ET";
            $len = strlen($contentStr);

            $pdfContent = "%PDF-1.4\n";
            $pdfContent .= "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
            $pdfContent .= "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
            $pdfContent .= "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj\n";
            $pdfContent .= "4 0 obj\n<< /Length {$len} >>\nstream\n{$contentStr}\nendstream\nendobj\n";
            $pdfContent .= "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";
            $pdfContent .= "xref\n0 6\n0000000000 65535 f \n0000000009 00000 n \n0000000058 00000 n \n0000000115 00000 n \n0000000244 00000 n \n0000000495 00000 n \ntrailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n566\n%%EOF";

            File::put($fullPath, $pdfContent);

            Document::create([
                'title' => $docTitle,
                'uploaded_by' => $sysUser->id,
                'category_id' => $category->id,
                'file_path' => $relativeFilePath,
                'status' => $status,
                'visibility' => 'public',
                'created_at' => now()->subDays(count($qaDocuments) - $index),
                'updated_at' => now()->subDays(count($qaDocuments) - $index),
            ]);
        }

        $this->command?->info('Successfully seeded realistic institutional QA PDF documents in storage/app/public/documents.');
    }
}
