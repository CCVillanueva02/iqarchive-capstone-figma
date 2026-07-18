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
            'faculty-member' => 'BU Faculty Member',
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
                'program' => null,
                'college' => null,
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
            [
                'first_name' => 'BU Faculty',
                'last_name' => 'Member',
                'email' => 'faculty@example.com',
                'role' => 'faculty-member',
                'program' => 'BSCS',
                'college' => null,
            ],
        ];

        foreach ($usersToSeed as $userData) {
            $roleId = $roles[$userData['role']]->id;
            $programId = $userData['program'] ? $programs[$userData['program']]->id : null;
            $collegeId = $userData['college'] ? $colleges[$userData['college']]->id : null;

            User::factory()->create([
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'email' => $userData['email'],
                'role_id' => $roleId,
                'program_id' => $programId,
                'college_id' => $collegeId,
            ]);
        }

        // 6. Seed Audit Logs
        $users = User::all();
        $actions = [
            'login', 'logout', 'document_upload', 'document_approve', 'document_reject', 'document_delete'
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
