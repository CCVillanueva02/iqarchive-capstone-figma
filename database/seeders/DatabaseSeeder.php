<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\College;
use App\Models\Program;
use App\Models\DocumentCategory;
use App\Models\Document;
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
            'task-force-member' => 'QA Task Force Member',
            'college-head' => 'College Head (Dean)',
            'program-chair' => 'BU Program Chair',
        ];

        $roles = [];
        foreach ($rolesData as $nameCode => $displayName) {
            $roles[$nameCode] = Role::firstOrCreate(
                ['role_name' => $nameCode],
                ['description' => $displayName]
            );
        }

        // 2. Seed Colleges
        $collegesData = [
            'CS' => 'BU College of Science',
            'CENG' => 'BU College of Engineering',
            'CAL' => 'BU College of Arts and Letters',
        ];

        $colleges = [];
        foreach ($collegesData as $code => $name) {
            $colleges[$code] = College::firstOrCreate(
                ['code' => $code],
                ['name' => $name]
            );
        }

        // 3. Seed Programs
        $programsData = [
            'CS' => [
                'BSCS' => ['name' => 'BS Computer Science', 'level' => 'Level IV Re-accredited'],
                'BSIT' => ['name' => 'BS Information Technology', 'level' => 'Level III Accredited'],
                'BSBIO' => ['name' => 'BS Biology', 'level' => 'Level III Accredited'],
            ],
            'CENG' => [
                'BSCE' => ['name' => 'BS Civil Engineering', 'level' => 'Level III Accredited'],
                'BSME' => ['name' => 'BS Mechanical Engineering', 'level' => 'Level II Accredited'],
            ],
        ];

        $programs = [];
        foreach ($programsData as $collegeCode => $collegePrograms) {
            $college = $colleges[$collegeCode];
            foreach ($collegePrograms as $code => $info) {
                $programs[$code] = Program::firstOrCreate(
                    ['code' => $code],
                    [
                        'college_id' => $college->id,
                        'name' => $info['name'],
                        'accreditation_level' => $info['level'],
                    ]
                );
            }
        }

        // Seed remaining programs programmatically to reach 126 (matches the Welcome Page)
        // We have 5 programs already seeded (BSCS, BSIT, BSBIO, BSCE, BSME)
        $colIds = array_values($colleges);

        // 75 more Baccalaureate (to reach 80 total)
        for ($i = 6; $i <= 80; $i++) {
            $college = $colIds[$i % count($colIds)];
            $programs['BSP' . $i] = Program::firstOrCreate(
                ['code' => "BSP" . $i],
                [
                    'college_id' => $college->id,
                    'name' => "BS Program " . $i,
                ]
            );
        }

        // 39 Master's programs
        for ($i = 1; $i <= 39; $i++) {
            $college = $colIds[$i % count($colIds)];
            $programs['MSP' . $i] = Program::firstOrCreate(
                ['code' => "MSP" . $i],
                [
                    'college_id' => $college->id,
                    'name' => "MS Program " . $i,
                ]
            );
        }

        // 7 Doctoral programs
        for ($i = 1; $i <= 7; $i++) {
            $college = $colIds[$i % count($colIds)];
            $programs['PHDP' . $i] = Program::firstOrCreate(
                ['code' => "PHDP" . $i],
                [
                    'college_id' => $college->id,
                    'name' => "PhD Program " . $i,
                ]
            );
        }

        // 2 Post Bacc programs
        for ($i = 1; $i <= 2; $i++) {
            $college = $colIds[$i % count($colIds)];
            $programs['PBP' . $i] = Program::firstOrCreate(
                ['code' => "PBP" . $i],
                [
                    'college_id' => $college->id,
                    'name' => "Post Bacc Program " . $i,
                ]
            );
        }

        // 4. Seed Document Categories
        $categoriesData = [
            'Uncategorized Documents' => 'General and uncategorized institution documents.',
            'Policies & Issuances' => 'Administrative orders, memorandums, circulars, and university code documents.',
            'Instruments' => 'Internal QA self-evaluation spreadsheets, numerical rating guides, and diagnostic compliance evaluations.',
            'Memoranda' => 'Official office memorandums, notices of meetings, and executive directives.',
            'Correspondences' => 'Official letters to/from colleges, AACCUP, and administrative offices.',
            'Faculty Profile' => 'Faculty credentials, curriculum vitae, and loads.',
            'Curriculum / Syllabus' => 'Official course curriculum structure and syllabi.',
        ];

        foreach ($categoriesData as $name => $desc) {
            DocumentCategory::firstOrCreate(
                ['name' => $name],
                ['description' => $desc]
            );
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
                'first_name' => 'QA Task Force',
                'last_name' => 'Member',
                'email' => 'taskforcemember@example.com',
                'role' => 'task-force-member',
                'program' => 'BSCS',
                'college' => 'CS',
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
            // Multi-Role Accounts
            [
                'first_name' => 'IQA Member',
                'last_name' => '(Multi-Role)',
                'email' => 'iqamember-multirole@example.com',
                'role' => 'iqa-member',
                'extra_roles' => ['task-force'],
                'program' => null,
                'college' => null,
            ],
            [
                'first_name' => 'College Head',
                'last_name' => '(Multi-Role)',
                'email' => 'dean-multirole@example.com',
                'role' => 'college-head',
                'extra_roles' => ['task-force'],
                'program' => null,
                'college' => 'CS',
            ],
            [
                'first_name' => 'Program Chair',
                'last_name' => '(Multi-Role)',
                'email' => 'chair-multirole@example.com',
                'role' => 'program-chair',
                'extra_roles' => ['task-force-member'],
                'program' => 'BSCS',
                'college' => null,
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'email' => 'msantos@example.com',
                'role' => 'task-force',
                'program' => 'BSCS',
                'college' => 'CS',
            ],
            [
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'email' => 'jdelacruz@example.com',
                'role' => 'task-force',
                'program' => 'BSIT',
                'college' => 'CS',
            ],
            [
                'first_name' => 'Dr. Aris',
                'last_name' => 'Ordoñez',
                'email' => 'aordonez@example.com',
                'role' => 'program-chair',
                'program' => 'BSIT',
                'college' => 'CS',
            ],
            [
                'first_name' => 'Prof. Elena',
                'last_name' => 'Reyes',
                'email' => 'ereyes@example.com',
                'role' => 'task-force',
                'program' => 'BSBIO',
                'college' => 'CS',
            ],
            [
                'first_name' => 'Dr. Carlos',
                'last_name' => 'Mendoza',
                'email' => 'cmendoza@example.com',
                'role' => 'college-head',
                'program' => null,
                'college' => 'CENG',
            ],
            [
                'first_name' => 'Engr. Rob',
                'last_name' => 'Alcantara',
                'email' => 'ralcantara@example.com',
                'role' => 'program-chair',
                'program' => 'BSCE',
                'college' => 'CENG',
            ],
            [
                'first_name' => 'Engr. Sarah',
                'last_name' => 'Gomez',
                'email' => 'sgomez@example.com',
                'role' => 'task-force',
                'program' => 'BSCE',
                'college' => 'CENG',
            ],
            [
                'first_name' => 'Engr. Mark',
                'last_name' => 'Torres',
                'email' => 'mtorres@example.com',
                'role' => 'task-force',
                'program' => 'BSME',
                'college' => 'CENG',
            ],
            [
                'first_name' => 'Prof. Grace',
                'last_name' => 'Villanueva',
                'email' => 'gvillanueva@example.com',
                'role' => 'iqa-member',
                'program' => null,
                'college' => 'CS',
            ],
            [
                'first_name' => 'Dr. Ramon',
                'last_name' => 'Bautista',
                'email' => 'rbautista@example.com',
                'role' => 'accreditor',
                'program' => 'BSCS',
                'college' => 'CS',
            ],
        ];

        $seededUsers = [];
        foreach ($usersToSeed as $userData) {
            $roleId = $roles[$userData['role']]->id;
            $programId = $userData['program'] ? $programs[$userData['program']]->id : null;
            $collegeId = $userData['college'] ? $colleges[$userData['college']]->id : null;

            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'first_name' => $userData['first_name'],
                    'last_name' => $userData['last_name'],
                    'role_id' => $roleId,
                    'program_id' => $programId,
                    'college_id' => $collegeId,
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                    'status' => 'active',
                ]
            );

            $rolesToSync = [$roleId];
            if (isset($userData['extra_roles'])) {
                foreach ($userData['extra_roles'] as $extraRoleCode) {
                    if (isset($roles[$extraRoleCode])) {
                        $rolesToSync[] = $roles[$extraRoleCode]->id;
                    }
                }
            }
            $user->roles()->sync(array_unique($rolesToSync));
            $seededUsers[] = $user;
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

        // Seed realistic Access & Session logs (paired Login and Logout timestamps)
        foreach ($users->take(12) as $index => $uItem) {
            $loginTime = now()->subHours(fake()->numberBetween(1, 48));
            \App\Models\AuditLog::create([
                'user_id' => $uItem->id,
                'action' => 'login',
                'target_type' => \App\Models\User::class,
                'target_id' => $uItem->id,
                'timestamp' => $loginTime,
            ]);

            // 75% of logins have paired logout, 25% are Active Session
            if ($index % 4 !== 0) {
                \App\Models\AuditLog::create([
                    'user_id' => $uItem->id,
                    'action' => 'logout',
                    'target_type' => \App\Models\User::class,
                    'target_id' => $uItem->id,
                    'timestamp' => (clone $loginTime)->addMinutes(fake()->numberBetween(12, 180)),
                ]);
            }
        }

        // Seed Account Creation & Management audit logs
        $adminUserForAudit = $users->first();
        foreach ($users->skip(2)->take(6) as $uItem) {
            \App\Models\AuditLog::create([
                'user_id' => $adminUserForAudit->id,
                'action' => 'CREATE_USER',
                'target_type' => \App\Models\User::class,
                'target_id' => $uItem->id,
                'timestamp' => now()->subDays(fake()->numberBetween(1, 14)),
            ]);
        }

        // Seed File Modification audit logs
        foreach (range(1, 15) as $index) {
            $user = $users->random();
            $action = fake()->randomElement(['document_upload', 'document_approve', 'document_reject', 'document_update', 'document_delete']);

            \App\Models\AuditLog::create([
                'user_id' => $user->id,
                'action' => $action,
                'target_type' => \App\Models\Document::class,
                'target_id' => fake()->numberBetween(1, 50),
                'timestamp' => now()->subMinutes(fake()->numberBetween(10, 5000)),
            ]);
        }

        // 9. Seed Task Forces
        $csCollege = $colleges['CS'] ?? College::first();
        $cengCollege = $colleges['CENG'] ?? College::skip(1)->first();
        $adminUser = $users->where('role_id', $roles['iqa-admin']->id)->first() ?? $users->first();

        $tf1 = \App\Models\TaskForce::create([
            'name' => 'BSCS AACCUP Level III Accreditation Task Force',
            'college_id' => $csCollege->id,
            'program_id' => $programs['BSCS']->id ?? null,
            'purpose' => 'Responsible for assembling Area I to Area X compliance evidence folders for BSCS Level III Re-accreditation evaluation.',
            'status' => 'active',
            'created_by' => $adminUser->id,
        ]);

        $tf2 = \App\Models\TaskForce::create([
            'name' => 'College of Engineering Quality Assurance Committee',
            'college_id' => $cengCollege->id,
            'purpose' => 'Conduct quarterly internal quality audits, review syllabus outcomes, and monitor BSCE & BSME instrument compliance.',
            'status' => 'active',
            'created_by' => $adminUser->id,
        ]);

        $tf3 = \App\Models\TaskForce::create([
            'name' => 'Institutional Vision & Mission Review Committee',
            'college_id' => $csCollege->id,
            'purpose' => 'Evaluate stakeholder alignment matrix for BU College of Science strategic goals.',
            'status' => 'completed',
            'created_by' => $adminUser->id,
        ]);

        // Attach members
        $memberUsers = $users->take(4);
        foreach ($memberUsers as $mUser) {
            \App\Models\TaskForceMember::create([
                'task_force_id' => $tf1->id,
                'user_id' => $mUser->id,
                'role_in_team' => 'member',
                'assigned_at' => now()->subDays(10),
            ]);
        }

        foreach ($users->skip(2)->take(3) as $mUser) {
            \App\Models\TaskForceMember::create([
                'task_force_id' => $tf2->id,
                'user_id' => $mUser->id,
                'role_in_team' => 'member',
                'assigned_at' => now()->subDays(5),
            ]);
        }

        foreach ($users->take(2) as $mUser) {
            \App\Models\TaskForceMember::create([
                'task_force_id' => $tf3->id,
                'user_id' => $mUser->id,
                'role_in_team' => 'member',
                'assigned_at' => now()->subDays(20),
            ]);
        }

        // 6. Seed Actual Sample Documents (test1.pdf to test5.pdf)
        $sysUser = \App\Models\User::where('email', 'sysadmin@example.com')->first();
        if ($sysUser) {
            $categoriesToSeedDocs = [
                'Policies & Issuances' => 'test1 - Bicol University Governance Policy 2026',
                'Instruments' => 'test2 - Level IV Accreditation Instrument',
                'Memoranda' => 'test3 - Quality Audit Memorandum 2026-042',
                'Correspondences' => 'test4 - AACCUP Official Endorsement Letter',
                'Uncategorized Documents' => 'test5 - General Quality Guidelines Manual',
            ];

            $index = 1;
            foreach ($categoriesToSeedDocs as $catName => $docTitle) {
                $category = DocumentCategory::firstOrCreate(
                    ['name' => $catName],
                    ['description' => 'General documents for ' . $catName]
                );

                $fileName = "test{$index}.pdf";
                $relativeFilePath = "documents/{$fileName}";
                $fullPath = storage_path("app/public/{$relativeFilePath}");
                $dir = dirname($fullPath);

                if (!file_exists($dir)) {
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
}
