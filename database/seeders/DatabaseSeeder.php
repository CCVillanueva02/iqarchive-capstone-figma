<?php

namespace Database\Seeders;

use App\Models\User;
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
        $roles = [
            'system-administrator' => [
                'name' => 'System Administrator',
                'email' => 'sysadmin@example.com',
            ],
            'iqa-admin' => [
                'name' => 'Maria Reyes', // Matches the mockup's IQA Staff/Admin profile
                'email' => 'iqaadmin@example.com',
            ],
            'iqa-member' => [
                'name' => 'IQA Staff Member',
                'email' => 'iqamember@example.com',
            ],
            'accreditor' => [
                'name' => 'AACCUP Accreditor',
                'email' => 'accreditor@example.com',
            ],
            'university-administrator' => [
                'name' => 'BU Executive Admin',
                'email' => 'buadmin@example.com',
            ],
            'task-force' => [
                'name' => 'QA Task Force Lead',
                'email' => 'taskforce@example.com',
            ],
            'program-chair' => [
                'name' => 'BU Program Chair',
                'email' => 'chair@example.com',
            ],
            'faculty-member' => [
                'name' => 'BU Faculty Member',
                'email' => 'faculty@example.com',
            ],
        ];

        foreach ($roles as $role => $data) {
            User::factory()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $role,
            ]);
        }
    }
}
