<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class ComplianceUserSeeder extends Seeder
{
    public function run(): void
    {
        $college = College::firstOrCreate(
            ['code' => 'CS'],
            ['name' => 'College of Science']
        );

        $roleDean = Role::firstOrCreate(
            ['name' => 'college_dean'],
            ['display_name' => 'College Dean', 'description' => 'Academic College Dean']
        );

        $roleTaskForce = Role::firstOrCreate(
            ['name' => 'task_force_member'],
            ['display_name' => 'Task Force Member', 'description' => 'Program Task Force Member']
        );

        // 1. College Dean Account
        $dean = User::withoutGlobalScopes()->firstOrCreate(
            ['email' => 'maria.santos@bicol-u.edu.ph'],
            [
                'name' => 'Dr. Maria Santos',
                'college_id' => $college->id,
                'google_id' => 'google_oauth_9876543210123',
                'avatar_url' => 'https://lh3.googleusercontent.com/a/dean-santos',
                'status' => 'active',
            ]
        );
        $dean->roles()->syncWithoutDetaching([$roleDean->id]);

        // 2. Active Task Force Faculty Account
        $faculty = User::withoutGlobalScopes()->firstOrCreate(
            ['email' => 'juan.delacruz@bicol-u.edu.ph'],
            [
                'name' => 'Prof. Juan Dela Cruz',
                'college_id' => $college->id,
                'google_id' => 'google_oauth_1092837465928',
                'avatar_url' => 'https://lh3.googleusercontent.com/a/faculty-juan',
                'status' => 'active',
            ]
        );
        $faculty->roles()->syncWithoutDetaching([$roleTaskForce->id]);

        // 3. Newly Provisioned Account (Pending Approval)
        $pending = User::withoutGlobalScopes()->firstOrCreate(
            ['email' => 'elena.roces@bicol-u.edu.ph'],
            [
                'name' => 'Elena Roces',
                'college_id' => $college->id,
                'google_id' => 'google_oauth_5544332211009',
                'avatar_url' => null,
                'status' => 'inactive',
            ]
        );
        $pending->roles()->syncWithoutDetaching([$roleTaskForce->id]);
    }
}
