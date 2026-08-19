<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolesData = [
            'system-administrator' => 'System Administrator',
            'iqa-staff' => 'IQA Member',
            'accreditor' => 'AACCUP Accreditor',
            'university-administrator' => 'BU Executive',
            'college-head' => 'College Head',
            'task-force-member' => 'Task Force',
        ];

        foreach ($rolesData as $nameCode => $displayName) {
            Role::firstOrCreate(
                ['role_name' => $nameCode],
                ['description' => $displayName]
            );
        }
    }
}
