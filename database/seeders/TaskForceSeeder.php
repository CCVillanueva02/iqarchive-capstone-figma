<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Program;
use App\Models\Role;
use App\Models\TaskForce;
use App\Models\TaskForceMember;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskForceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $colleges = College::all()->keyBy('code');
        $programs = Program::all()->keyBy('code');
        $iqaStaffRoleId = Role::where('role_name', 'iqa-staff')->value('id');

        $csCollege = $colleges->get('CS') ?? College::first();
        $cengCollege = $colleges->get('CENG') ?? College::skip(1)->first();

        if (!$csCollege || !$cengCollege || $users->isEmpty()) {
            return;
        }

        $adminUser = $users->firstWhere('role_id', $iqaStaffRoleId) ?? $users->first();
        $csDean = $users->firstWhere('email', 'dean@example.com');
        $cengDean = $users->firstWhere('email', 'cmendoza@example.com');

        $tf1 = TaskForce::create([
            'name' => 'BSCS AACCUP Level III Accreditation Task Force',
            'college_id' => $csCollege->id,
            'program_id' => $programs->has('BSCS') ? $programs->get('BSCS')->id : null,
            'purpose' => 'Responsible for assembling Area I to Area X compliance evidence folders for BSCS Level III Re-accreditation evaluation.',
            'status' => 'active',
            'created_by' => $adminUser->id,
        ]);

        $tf2 = TaskForce::create([
            'name' => 'College of Engineering Quality Assurance Committee',
            'college_id' => $cengCollege->id,
            'purpose' => 'Conduct quarterly internal quality audits, review syllabus outcomes, and monitor BSCE & BSME instrument compliance.',
            'status' => 'active',
            'created_by' => $adminUser->id,
        ]);

        $tf3 = TaskForce::create([
            'name' => 'Institutional Vision & Mission Review Committee',
            'college_id' => $csCollege->id,
            'purpose' => 'Evaluate stakeholder alignment matrix for BU College of Science strategic goals.',
            'status' => 'completed',
            'created_by' => $adminUser->id,
        ]);

        // Attach Dean as Lead for each Task Force
        if ($csDean) {
            TaskForceMember::firstOrCreate(
                ['task_force_id' => $tf1->id, 'user_id' => $csDean->id],
                ['role_in_team' => 'lead', 'assigned_at' => now()->subDays(10)]
            );
            TaskForceMember::firstOrCreate(
                ['task_force_id' => $tf3->id, 'user_id' => $csDean->id],
                ['role_in_team' => 'lead', 'assigned_at' => now()->subDays(20)]
            );
        }

        if ($cengDean) {
            TaskForceMember::firstOrCreate(
                ['task_force_id' => $tf2->id, 'user_id' => $cengDean->id],
                ['role_in_team' => 'lead', 'assigned_at' => now()->subDays(5)]
            );
        }

        // Attach members
        $memberUsers = $users->where('id', '!=', $csDean?->id)->take(4);
        foreach ($memberUsers as $mUser) {
            TaskForceMember::firstOrCreate(
                ['task_force_id' => $tf1->id, 'user_id' => $mUser->id],
                ['role_in_team' => 'member', 'assigned_at' => now()->subDays(10)]
            );
        }

        foreach ($users->where('id', '!=', $cengDean?->id)->skip(2)->take(3) as $mUser) {
            TaskForceMember::firstOrCreate(
                ['task_force_id' => $tf2->id, 'user_id' => $mUser->id],
                ['role_in_team' => 'member', 'assigned_at' => now()->subDays(5)]
            );
        }
    }
}
