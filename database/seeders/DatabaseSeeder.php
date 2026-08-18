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

        // 2. Seed Colleges & Programs
        $this->call(BUProgramsSeeder::class);

        $colleges = College::all();
        $programs = Program::all();
        
        // Helper to find by code or fallback to random
        $getCollege = fn($code) => $colleges->firstWhere('code', $code) ?? $colleges->random();
        $getProgram = fn($code) => $programs->firstWhere('code', $code) ?? $programs->random();


        // Seed Offices
        $this->call(OfficeSeeder::class);

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
                'assign_program' => false,
                'assign_college' => false,
            ],
            [
                'first_name' => 'IQA',
                'last_name' => 'Admin',
                'email' => 'iqaadmin@example.com',
                'role' => 'iqa-admin',
                'assign_program' => false,
                'assign_college' => false,
            ],
            [
                'first_name' => 'IQA',
                'last_name' => 'Member',
                'email' => 'iqamember@example.com',
                'role' => 'iqa-member',
                'assign_program' => false,
                'assign_college' => false,
            ],
            [
                'first_name' => 'AACCUP',
                'last_name' => 'Accreditor',
                'email' => 'accreditor@example.com',
                'role' => 'accreditor',
                'assign_program' => true,
                'assign_college' => true,
            ],
            [
                'first_name' => 'BU Executive',
                'last_name' => 'Admin',
                'email' => 'buadmin@example.com',
                'role' => 'university-administrator',
                'assign_program' => false,
                'assign_college' => false,
            ],
            [
                'first_name' => 'QA Task Force',
                'last_name' => 'Lead',
                'email' => 'taskforce@example.com',
                'role' => 'task-force',
                'assign_program' => true,
                'assign_college' => false,
            ],
            [
                'first_name' => 'QA Task Force',
                'last_name' => 'Member',
                'email' => 'taskforcemember@example.com',
                'role' => 'task-force-member',
                'assign_program' => true,
                'assign_college' => true,
            ],
            [
                'first_name' => 'College',
                'last_name' => 'Dean',
                'email' => 'dean@example.com',
                'role' => 'college-head',
                'assign_program' => false,
                'assign_college' => true,
            ],
            [
                'first_name' => 'BU Program',
                'last_name' => 'Chair',
                'email' => 'chair@example.com',
                'role' => 'program-chair',
                'assign_program' => true,
                'assign_college' => false,
            ],
            // Multi-Role Accounts
            [
                'first_name' => 'IQA Member',
                'last_name' => '(Multi-Role)',
                'email' => 'iqamember-multirole@example.com',
                'role' => 'iqa-member',
                'extra_roles' => ['task-force'],
                'assign_program' => false,
                'assign_college' => false,
            ],
            [
                'first_name' => 'College Head',
                'last_name' => '(Multi-Role)',
                'email' => 'dean-multirole@example.com',
                'role' => 'college-head',
                'extra_roles' => ['task-force'],
                'assign_program' => false,
                'assign_college' => true,
            ],
            [
                'first_name' => 'Program Chair',
                'last_name' => '(Multi-Role)',
                'email' => 'chair-multirole@example.com',
                'role' => 'program-chair',
                'extra_roles' => ['task-force-member'],
                'assign_program' => true,
                'assign_college' => false,
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'email' => 'msantos@example.com',
                'role' => 'task-force',
                'assign_program' => true,
                'assign_college' => true,
            ],
            [
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'email' => 'jdelacruz@example.com',
                'role' => 'task-force',
                'assign_program' => true,
                'assign_college' => true,
            ],
            [
                'first_name' => 'Dr. Aris',
                'last_name' => 'Ordoñez',
                'email' => 'aordonez@example.com',
                'role' => 'program-chair',
                'assign_program' => true,
                'assign_college' => true,
            ],
            [
                'first_name' => 'Prof. Elena',
                'last_name' => 'Reyes',
                'email' => 'ereyes@example.com',
                'role' => 'task-force',
                'assign_program' => true,
                'assign_college' => true,
            ],
            [
                'first_name' => 'Dr. Carlos',
                'last_name' => 'Mendoza',
                'email' => 'cmendoza@example.com',
                'role' => 'college-head',
                'assign_program' => false,
                'assign_college' => true,
            ],
            [
                'first_name' => 'Engr. Rob',
                'last_name' => 'Alcantara',
                'email' => 'ralcantara@example.com',
                'role' => 'program-chair',
                'assign_program' => true,
                'assign_college' => true,
            ],
            [
                'first_name' => 'Engr. Sarah',
                'last_name' => 'Gomez',
                'email' => 'sgomez@example.com',
                'role' => 'task-force',
                'assign_program' => true,
                'assign_college' => true,
            ],
            [
                'first_name' => 'Engr. Mark',
                'last_name' => 'Torres',
                'email' => 'mtorres@example.com',
                'role' => 'task-force',
                'assign_program' => true,
                'assign_college' => true,
            ],
            [
                'first_name' => 'Prof. Grace',
                'last_name' => 'Villanueva',
                'email' => 'gvillanueva@example.com',
                'role' => 'iqa-member',
                'assign_program' => false,
                'assign_college' => true,
            ],
            [
                'first_name' => 'Dr. Ramon',
                'last_name' => 'Bautista',
                'email' => 'rbautista@example.com',
                'role' => 'accreditor',
                'assign_program' => true,
                'assign_college' => true,
            ],
        ];

        $seededUsers = [];
        foreach ($usersToSeed as $userData) {
            $roleId = $roles[$userData['role']]->id;
            $programId = $userData['assign_program'] ? $programs->random()->id : null;
            $collegeId = $userData['assign_college'] ? $colleges->random()->id : null;

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

        // 6. Call TestPdfSeeder to generate 50 test PDF documents (test1.pdf to test50.pdf)
        $this->call(TestPdfSeeder::class);
    }
}
