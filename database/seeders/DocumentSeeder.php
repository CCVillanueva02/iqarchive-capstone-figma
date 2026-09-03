<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\DocumentAccessRequest;
use App\Models\DocumentCategory;
use App\Models\DocumentOCRValidation;
use App\Models\DocumentReview;
use App\Models\Program;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = DocumentCategory::all();
        $allPrograms = Program::all();
        $iqaStaffRoleId = Role::where('role_name', 'iqa-staff')->value('id');
        $accreditorRoleId = Role::where('role_name', 'accreditor')->value('id');

        $iqaStaffUser = $users->firstWhere('role_id', $iqaStaffRoleId) ?? $users->first();
        $accreditorUser = $users->firstWhere('role_id', $accreditorRoleId);

        if ($users->isEmpty() || $categories->isEmpty() || $allPrograms->isEmpty()) {
            return;
        }

        for ($i = 1; $i <= 150; $i++) {
            $uploader = $users->random();
            $program = $allPrograms->random();
            $category = $categories->random();

            $status = 'approved';
            if ($i <= 8) {
                $status = 'pending';
            } elseif ($i <= 14) {
                $status = 'rejected';
            }

            $doc = Document::create([
                'uploaded_by' => $uploader->id,
                'program_id' => $program->id,
                'category_id' => $category->id,
                'title' => 'Accreditation Portfolio Item '.$i,
                'file_path' => "documents/mock_doc_{$i}.pdf",
                'status' => $status,
                'visibility' => $i % 4 === 0 ? 'public' : 'restricted',
            ]);

            // Seed OCR validation record
            $ocrStatus = 'validated';
            if ($status === 'pending') {
                $ocrStatus = $i % 3 === 0 ? 'pending' : 'validated';
            } elseif ($i % 12 === 0) {
                $ocrStatus = 'failed';
            }

            DocumentOCRValidation::create([
                'document_id' => $doc->id,
                'validation_status' => $ocrStatus,
                'validated_at' => $ocrStatus === 'validated' ? now()->subDays(rand(1, 10)) : null,
                'extracted_data' => "Mock extracted OCR text content for compliance file {$doc->title}.",
            ]);

            // Seed review record
            if ($status !== 'pending' && $iqaStaffUser) {
                DocumentReview::create([
                    'document_id' => $doc->id,
                    'reviewed_by' => $iqaStaffUser->id,
                    'decision' => $status,
                    'remarks' => $status === 'rejected' ? 'Document requires official signature on the last page.' : 'Documentation compiled successfully.',
                    'reviewed_at' => now()->subDays(rand(1, 5)),
                ]);
            }

            // Seed access requests
            if ($i % 8 === 0 && $accreditorUser) {
                DocumentAccessRequest::create([
                    'document_id' => $doc->id,
                    'requested_by' => $accreditorUser->id,
                    'status' => $i % 16 === 0 ? 'pending' : 'approved',
                    'remarks' => 'Access requested for external audit purposes.',
                    'approved_by' => $i % 16 === 0 ? null : ($iqaStaffUser ? $iqaStaffUser->id : null),
                    'approved_at' => $i % 16 === 0 ? null : now()->subDays(1),
                    'expires_at' => $i % 16 === 0 ? null : now()->addDays(30),
                ]);
            }
        }
    }
}
