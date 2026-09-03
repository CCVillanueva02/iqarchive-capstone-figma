<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Program;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all()->keyBy('role_name');
        $colleges = College::all()->keyBy('code');
        $programs = Program::all()->keyBy('code');

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
                'last_name' => 'Staff',
                'email' => 'iqastaff@example.com',
                'role' => 'iqa-staff',
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
                'first_name' => 'Task Force',
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
                'first_name' => 'Dr. Carlos',
                'last_name' => 'Mendoza',
                'email' => 'cmendoza@example.com',
                'role' => 'college-head',
                'program' => null,
                'college' => 'CENG',
            ],
            [
                'first_name' => 'Prof. Grace',
                'last_name' => 'Villanueva',
                'email' => 'gvillanueva@example.com',
                'role' => 'iqa-staff',
                'program' => null,
                'college' => 'CS',
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'email' => 'msantos@example.com',
                'role' => 'task-force-member',
                'program' => 'BSCS',
                'college' => 'CS',
            ],
            [
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'email' => 'jdelacruz@example.com',
                'role' => 'task-force-member',
                'program' => 'BSIT',
                'college' => 'CS',
            ],
            [
                'first_name' => 'Prof. Elena',
                'last_name' => 'Reyes',
                'email' => 'ereyes@example.com',
                'role' => 'task-force-member',
                'program' => 'BSBIO',
                'college' => 'CS',
            ],
            [
                'first_name' => 'Engr. Sarah',
                'last_name' => 'Gomez',
                'email' => 'sgomez@example.com',
                'role' => 'task-force-member',
                'program' => 'BSCE',
                'college' => 'CENG',
            ],
            [
                'first_name' => 'Engr. Mark',
                'last_name' => 'Torres',
                'email' => 'mtorres@example.com',
                'role' => 'task-force-member',
                'program' => 'BSME',
                'college' => 'CENG',
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

        foreach ($usersToSeed as $userData) {
            $role = $roles->get($userData['role']);
            if (! $role) {
                continue;
            }

            $programId = $userData['program'] && $programs->has($userData['program'])
                ? $programs->get($userData['program'])->id
                : null;
            $collegeId = $userData['college'] && $colleges->has($userData['college'])
                ? $colleges->get($userData['college'])->id
                : null;

            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'first_name' => $userData['first_name'],
                    'last_name' => $userData['last_name'],
                    'role_id' => $role->id,
                    'program_id' => $programId,
                    'college_id' => $collegeId,
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                    'status' => 'active',
                ]
            );

            $rolesToSync = [$role->id];
            if (isset($userData['extra_roles'])) {
                foreach ($userData['extra_roles'] as $extraRoleCode) {
                    if ($roles->has($extraRoleCode)) {
                        $rolesToSync[] = $roles->get($extraRoleCode)->id;
                    }
                }
            }
            $user->roles()->sync(array_unique($rolesToSync));
        }
    }
}
