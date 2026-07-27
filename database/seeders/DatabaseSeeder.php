<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\College;
use App\Models\Program;
use App\Models\DocumentCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Roles
        $rolesData = [
            'system-administrator' => 'System Administrator',
            'iqa-admin' => 'IQA Admin',
            'iqa-member' => 'IQA Staff Member',
            'accreditor' => 'AACCUP Accreditor',
            'university-administrator' => 'BU Executive Admin',
            'task-force' => 'QA Task Force Lead',
            'college-head' => 'College Head (Dean)',
            'program-chair' => 'BU Program Chair',
        ];

        $roles = [];
        foreach ($rolesData as $nameCode => $displayName) {
            $roles[$nameCode] = Role::create([
                'role_name' => $nameCode,
                'description' => $displayName,
            ]);
        }

        // 2. Seed Colleges
        $collegesData = [
            'CS' => 'BU College of Science',
            'CENG' => 'BU College of Engineering',
            'CAL' => 'BU College of Arts and Letters',
        ];

        $colleges = [];
        foreach ($collegesData as $code => $name) {
            $colleges[$code] = College::create([
                'name' => $name,
                'code' => $code,
            ]);
        }

        // 3. Seed Programs
        $programsData = [
            'CS' => [
                'BSCS' => 'BS Computer Science',
                'BSIT' => 'BS Information Technology',
                'BSBIO' => 'BS Biology',
            ],
            'CENG' => [
                'BSCE' => 'BS Civil Engineering',
                'BSME' => 'BS Mechanical Engineering',
            ],
        ];

        $programs = [];
        foreach ($programsData as $collegeCode => $collegePrograms) {
            $college = $colleges[$collegeCode];
            foreach ($collegePrograms as $code => $name) {
                $programs[$code] = Program::create([
                    'college_id' => $college->id,
                    'name' => $name,
                    'code' => $code,
                ]);
            }
        }

        // Seed remaining programs programmatically to reach 126 (matches the Welcome Page)
        // We have 5 programs already seeded (BSCS, BSIT, BSBIO, BSCE, BSME)
        $colIds = array_values($colleges);

        // 75 more Baccalaureate (to reach 80 total)
        for ($i = 6; $i <= 80; $i++) {
            $college = $colIds[$i % count($colIds)];
            $programs['BSP' . $i] = Program::create([
                'college_id' => $college->id,
                'name' => "BS Program " . $i,
                'code' => "BSP" . $i,
            ]);
        }

        // 39 Master's programs
        for ($i = 1; $i <= 39; $i++) {
            $college = $colIds[$i % count($colIds)];
            $programs['MSP' . $i] = Program::create([
                'college_id' => $college->id,
                'name' => "MS Program " . $i,
                'code' => "MSP" . $i,
            ]);
        }

        // 7 Doctoral programs
        for ($i = 1; $i <= 7; $i++) {
            $college = $colIds[$i % count($colIds)];
            $programs['PHDP' . $i] = Program::create([
                'college_id' => $college->id,
                'name' => "PhD Program " . $i,
                'code' => "PHDP" . $i,
            ]);
        }

        // 2 Post Bacc programs
        for ($i = 1; $i <= 2; $i++) {
            $college = $colIds[$i % count($colIds)];
            $programs['PBP' . $i] = Program::create([
                'college_id' => $college->id,
                'name' => "Post Bacc Program " . $i,
                'code' => "PBP" . $i,
            ]);
        }

        // 4. Seed Document Categories
        $categoriesData = [
            'Faculty Profile' => 'Faculty credentials, curriculum vitae, and loads.',
            'Curriculum / Syllabus' => 'Official course curriculum structure and syllabi.',
            'Board Exam Performance' => 'Results and statistics of professional board examinations.',
            'College/Department Budget' => 'Financial allocations and expenditures reports.',
            'Student Performance' => 'Student achievement and grades summaries.',
        ];

        foreach ($categoriesData as $name => $desc) {
            DocumentCategory::create([
                'name' => $name,
                'description' => $desc,
            ]);
        }

        // 5. Seed Users
        $usersToSeed = [
            [
                'first_name' => 'Sys',
                'last_name' => 'Admin',
                'email' => 'sysadmin@example.com',
                'role' => 'system-administrator',
                'program' => null,
                'college' => null,
            ],
            [
                'first_name' => 'IQA',
                'last_name' => 'Admin',
                'email' => 'iqaadmin@example.com',
                'role' => 'iqa-admin',
                'program' => null,
                'college' => null,
            ],
            [
                'first_name' => 'IQA',
                'last_name' => 'Member',
                'email' => 'iqamember@example.com',
                'role' => 'iqa-member',
                'program' => null,
                'college' => null,
            ],
            [
                'first_name' => 'AACCUP',
                'last_name' => 'Accreditor',
                'email' => 'accreditor@example.com',
                'role' => 'accreditor',
                'program' => 'BSCS',
                'college' => 'CS',
            ],
            [
                'first_name' => 'BU Executive',
                'last_name' => 'Admin',
                'email' => 'buadmin@example.com',
                'role' => 'university-administrator',
                'program' => null,
                'college' => null,
            ],
            [
                'first_name' => 'QA Task Force',
                'last_name' => 'Lead',
                'email' => 'taskforce@example.com',
                'role' => 'task-force',
                'program' => 'BSCS',
                'college' => null,
            ],
            [
                'first_name' => 'CS Dean',
                'last_name' => 'Office',
                'email' => 'dean@example.com',
                'role' => 'college-head',
                'program' => null,
                'college' => 'CS',
            ],
            [
                'first_name' => 'BU Program',
                'last_name' => 'Chair',
                'email' => 'chair@example.com',
                'role' => 'program-chair',
                'program' => 'BSCS',
                'college' => null,
            ],
        ];

        $seededUsers = [];
        foreach ($usersToSeed as $userData) {
            $roleId = $roles[$userData['role']]->id;
            $programId = $userData['program'] ? $programs[$userData['program']]->id : null;
            $collegeId = $userData['college'] ? $colleges[$userData['college']]->id : null;

            $seededUsers[] = User::factory()->create([
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'email' => $userData['email'],
                'role_id' => $roleId,
                'program_id' => $programId,
                'college_id' => $collegeId,
            ]);
        }

        // 6. Seed Instruments & Compliance Requirements (AACCUP statistics)
        // Level IV: 11 programs
        // Level III: 32 programs
        // Level II: 35 programs
        // Level I: 38 programs
        // Candidate: 4 programs
        // Total = 120 accredited/candidate programs
        $allPrograms = Program::all();
        $progIndex = 0;

        $seedAccreditation = function ($levelName, $count, &$progIndex, $allPrograms) {
            for ($i = 1; $i <= $count; $i++) {
                if ($progIndex >= $allPrograms->count()) break;

                $program = $allPrograms[$progIndex++];

                $inst = \App\Models\Instrument::create([
                    'name' => "AACCUP {$levelName} Criteria for {$program->name}",
                    'code' => "INST-{$program->code}-" . strtoupper(str_replace(' ', '', $levelName)),
                    'level' => $levelName,
                    'description' => "Accreditation guidelines and evaluation areas for {$program->name} level {$levelName}.",
                ]);

                // Seed a compliance requirement for this program and instrument
                $status = 'complied';
                if ($progIndex % 6 === 0) {
                    $status = 'in_progress';
                } elseif ($progIndex % 15 === 0) {
                    $status = 'overdue';
                } elseif ($progIndex % 20 === 0) {
                    $status = 'pending';
                }

                \App\Models\ComplianceRequirement::create([
                    'instrument_id' => $inst->id,
                    'program_id' => $program->id,
                    'description' => "Complete documentation file compilations for {$levelName} accreditation.",
                    'due_date' => now()->addDays(rand(-30, 90)),
                    'status' => $status,
                ]);
            }
        };

        $seedAccreditation('Level IV', 11, $progIndex, $allPrograms);
        $seedAccreditation('Level III', 32, $progIndex, $allPrograms);
        $seedAccreditation('Level II', 35, $progIndex, $allPrograms);
        $seedAccreditation('Level I', 38, $progIndex, $allPrograms);
        $seedAccreditation('Candidate', 4, $progIndex, $allPrograms);

        // 7. Seed Documents & OCR Validations & Reviews & Requests
        $users = User::all();
        $categories = DocumentCategory::all();

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

            $doc = \App\Models\Document::create([
                'uploaded_by' => $uploader->id,
                'program_id' => $program->id,
                'category_id' => $category->id,
                'title' => "Accreditation Portfolio Item " . $i,
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

            \App\Models\DocumentOCRValidation::create([
                'document_id' => $doc->id,
                'validation_status' => $ocrStatus,
                'validated_at' => $ocrStatus === 'validated' ? now()->subDays(rand(1, 10)) : null,
                'extracted_data' => "Mock extracted OCR text content for compliance file {$doc->title}.",
            ]);

            // Seed review record
            if ($status !== 'pending') {
                \App\Models\DocumentReview::create([
                    'document_id' => $doc->id,
                    'reviewed_by' => $users->where('role_id', $roles['iqa-admin']->id)->first()->id,
                    'decision' => $status,
                    'remarks' => $status === 'rejected' ? 'Document requires official signature on the last page.' : 'Documentation compiled successfully.',
                    'reviewed_at' => now()->subDays(rand(1, 5)),
                ]);
            }

            // Seed access requests
            if ($i % 8 === 0) {
                $requester = $users->where('role_id', $roles['accreditor']->id)->first();
                if ($requester) {
                    \App\Models\DocumentAccessRequest::create([
                        'document_id' => $doc->id,
                        'requested_by' => $requester->id,
                        'status' => $i % 16 === 0 ? 'pending' : 'approved',
                        'remarks' => 'Access requested for external audit purposes.',
                        'approved_by' => $i % 16 === 0 ? null : $users->where('role_id', $roles['iqa-admin']->id)->first()->id,
                        'approved_at' => $i % 16 === 0 ? null : now()->subDays(1),
                        'expires_at' => $i % 16 === 0 ? null : now()->addDays(30),
                    ]);
                }
            }
        }

        // 8. Seed Audit Logs
        $actions = [
            'login',
            'logout',
            'document_upload',
            'document_approve',
            'document_reject',
            'document_delete'
        ];

        foreach (range(1, 25) as $index) {
            $user = $users->random();
            $action = fake()->randomElement($actions);

            \App\Models\AuditLog::create([
                'user_id' => $user->id,
                'action' => $action,
                'target_type' => str_contains($action, 'document') ? \App\Models\Document::class : \App\Models\User::class,
                'target_id' => fake()->numberBetween(1, 50),
                'timestamp' => now()->subMinutes(fake()->numberBetween(1, 10000)),
            ]);
        }
    }
}
