<?php

/**
 * ============================================================================
 * IQArchive v2 — Audit Log Mock Generator & Seeder
 * ============================================================================
 * File: database/seeders/AuditLogSeeder.php
 * Responsibility: Seeds realistic, multi-tenant audit events across all lifecycle
 *                 domains with cryptographic hashes, before/after diffs, and
 *                 distributed timestamps for UI and compliance testing.
 * Architecture: Database Seeder Layer
 * Security Context: Strictly non-destructive; seeds realistic immutable records.
 * ============================================================================
 */

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\College;
use App\Models\Document;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AuditLogSeeder extends Seeder
{
    /**
     * Run the audit log mock generator.
     */
    public function run(): void
    {
        // 1. Ensure required test colleges exist
        $colleges = [
            'CS' => College::firstOrCreate(['code' => 'CS'], ['name' => 'College of Science']),
            'CENG' => College::firstOrCreate(['code' => 'CENG'], ['name' => 'College of Engineering']),
            'CBEM' => College::firstOrCreate(['code' => 'CBEM'], ['name' => 'College of Business, Economics & Management']),
            'CAL' => College::firstOrCreate(['code' => 'CAL'], ['name' => 'College of Arts and Letters']),
            'CED' => College::firstOrCreate(['code' => 'CED'], ['name' => 'College of Education']),
        ];

        // 2. Ensure primary personas exist
        $roleAdmin = Role::firstOrCreate(['name' => 'system_admin'], ['display_name' => 'System Administrator']);
        $roleIqa = Role::firstOrCreate(['name' => 'iqa_staff'], ['display_name' => 'IQA Staff']);
        $roleDean = Role::firstOrCreate(['name' => 'college_dean'], ['display_name' => 'College Dean']);
        $roleTf = Role::firstOrCreate(['name' => 'task_force_member'], ['display_name' => 'Task Force Member']);

        $sysAdmin = User::withoutGlobalScopes()->firstOrCreate(
            ['email' => 'sysadmin@bicol-u.edu.ph'],
            ['name' => 'Engr. David Ramos (SysAdmin)', 'status' => 'active']
        );
        $sysAdmin->roles()->syncWithoutDetaching([$roleAdmin->id]);

        $iqaOfficer = User::withoutGlobalScopes()->firstOrCreate(
            ['email' => 'iqa.officer@bicol-u.edu.ph'],
            ['name' => 'Dr. Liza Magbanua (IQA Coordinator)', 'status' => 'active']
        );
        $iqaOfficer->roles()->syncWithoutDetaching([$roleIqa->id]);

        $deanCS = User::withoutGlobalScopes()->firstOrCreate(
            ['email' => 'dean.cs@bicol-u.edu.ph'],
            ['name' => 'Dr. Jane Santos (Dean Science)', 'college_id' => $colleges['CS']->id, 'status' => 'active']
        );
        $deanCS->roles()->syncWithoutDetaching([$roleDean->id]);

        $deanCENG = User::withoutGlobalScopes()->firstOrCreate(
            ['email' => 'dean.ceng@bicol-u.edu.ph'],
            ['name' => 'Dr. Robert Alcala (Dean Engineering)', 'college_id' => $colleges['CENG']->id, 'status' => 'active']
        );
        $deanCENG->roles()->syncWithoutDetaching([$roleDean->id]);

        $tfMemberCS = User::withoutGlobalScopes()->firstOrCreate(
            ['email' => 'tf.cs@bicol-u.edu.ph'],
            ['name' => 'Prof. Carlos Mendoza (Task Force CS)', 'college_id' => $colleges['CS']->id, 'status' => 'active']
        );
        $tfMemberCS->roles()->syncWithoutDetaching([$roleTf->id]);

        $tfMemberCENG = User::withoutGlobalScopes()->firstOrCreate(
            ['email' => 'tf.ceng@bicol-u.edu.ph'],
            ['name' => 'Prof. Andrea Bello (Task Force CENG)', 'college_id' => $colleges['CENG']->id, 'status' => 'active']
        );
        $tfMemberCENG->roles()->syncWithoutDetaching([$roleTf->id]);

        $now = Carbon::now();

        // 3. Define curated, realistic mock events
        $mockEvents = [
            // --- TODAY (24h Activity) ---
            [
                'action' => 'document.dean_approved',
                'target_type' => 'App\Models\Document',
                'target_id' => '104',
                'user_id' => $deanCS->id,
                'college_id' => $colleges['CS']->id,
                'ip_address' => '192.168.10.45',
                'created_at' => $now->copy()->subMinutes(12),
                'details' => [
                    'title' => 'BSCS Curriculum Revision Matrix 2026.pdf',
                    'file_hash' => '9f83b2c1a40b92e75e3c880124fb2965a3d7e8f192b4c5d6e7f8a9b0c1d2e3f4',
                    'area_id' => 3,
                    'area_name' => 'Curriculum & Instruction',
                    'previous' => ['status' => 'draft', 'is_endorsed' => false],
                    'updated' => ['status' => 'dean_appr', 'is_endorsed' => true, 'endorsed_at' => $now->copy()->subMinutes(12)->toIso8601String()],
                ],
            ],
            [
                'action' => 'document.upload.area',
                'target_type' => 'App\Models\Document',
                'target_id' => '105',
                'user_id' => $tfMemberCS->id,
                'college_id' => $colleges['CS']->id,
                'ip_address' => '192.168.10.78',
                'created_at' => $now->copy()->subMinutes(35),
                'details' => [
                    'title' => 'Faculty Performance Appraisal Reports SY 2025-2026.pdf',
                    'file_hash' => 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855',
                    'file_size_bytes' => 4582910,
                    'mime_type' => 'application/pdf',
                    'area_id' => 2,
                    'area_name' => 'Faculty Development',
                ],
            ],
            [
                'action' => 'auth.login',
                'target_type' => 'App\Models\User',
                'target_id' => (string) $sysAdmin->id,
                'user_id' => $sysAdmin->id,
                'college_id' => null,
                'ip_address' => '192.168.1.100',
                'created_at' => $now->copy()->subHours(1)->subMinutes(15),
                'details' => [
                    'provider' => 'google',
                    'email' => $sysAdmin->email,
                    'session_id' => 'sess_' . md5($now->toDateTimeString() . 'sysadmin'),
                ],
            ],
            [
                'action' => 'auth.domain_rejected',
                'target_type' => 'App\Models\User',
                'target_id' => null,
                'user_id' => null,
                'college_id' => null,
                'ip_address' => '112.198.88.24',
                'created_at' => $now->copy()->subHours(2),
                'details' => [
                    'attempted_email' => 'unauthorized.guest@gmail.com',
                    'reason' => 'Domain mismatch. Only @bicol-u.edu.ph accounts are permitted.',
                    'http_status' => 403,
                ],
            ],
            [
                'action' => 'document.iqa_approved',
                'target_type' => 'App\Models\Document',
                'target_id' => '98',
                'user_id' => $iqaOfficer->id,
                'college_id' => $colleges['CENG']->id,
                'ip_address' => '192.168.20.12',
                'created_at' => $now->copy()->subHours(3)->subMinutes(20),
                'details' => [
                    'title' => 'BSCE Civil Engineering Laboratory Safety Manual.pdf',
                    'file_hash' => '7d8f9e0a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6e7f8a9b0c1d2e3f4a5b6c7d8e',
                    'area_id' => 8,
                    'previous' => ['status' => 'dean_appr'],
                    'updated' => ['status' => 'iqa_appr', 'validated_by' => 'IQA Office'],
                ],
            ],
            [
                'action' => 'document.rejected',
                'target_type' => 'App\Models\Document',
                'target_id' => '95',
                'user_id' => $deanCENG->id,
                'college_id' => $colleges['CENG']->id,
                'ip_address' => '192.168.20.5',
                'created_at' => $now->copy()->subHours(4),
                'details' => [
                    'title' => 'Faculty Research Publications 2024.xlsx',
                    'file_hash' => '6a5b4c3d2e1f0a9b8c7d6e5f4a3b2c1d0e9f8a7b6c5d4e3f2a1b0c9d8e7f6a5b',
                    'remarks' => 'Returned for revision: Scanned copies of publication copyright pages missing.',
                    'previous' => ['status' => 'draft'],
                    'updated' => ['status' => 'rejected'],
                ],
            ],
            [
                'action' => 'taskforce.deficit_flagged',
                'target_type' => 'App\Models\Program',
                'target_id' => '2',
                'user_id' => $iqaOfficer->id,
                'college_id' => $colleges['CENG']->id,
                'ip_address' => '192.168.20.12',
                'created_at' => $now->copy()->subHours(5)->subMinutes(10),
                'details' => [
                    'program' => 'BS Civil Engineering',
                    'area' => 'Area V: Research',
                    'missing_benchmark' => 'Criterion 5.2.1 Institutional Research Incentive Grants',
                    'severity' => 'warning',
                ],
            ],

            // --- PAST 2 - 7 DAYS ---
            [
                'action' => 'document.upload.common',
                'target_type' => 'App\Models\Document',
                'target_id' => '50',
                'user_id' => $sysAdmin->id,
                'college_id' => null,
                'ip_address' => '192.168.1.100',
                'created_at' => $now->copy()->subDays(2)->setHour(10)->setMinute(15),
                'details' => [
                    'title' => 'Bicol University Student Handbook (2024 Revised Edition).pdf',
                    'category' => 'OSAS Policies',
                    'file_hash' => '3f4a5b6c7d8e9f0a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6e7f8a9b0c1d2e3f4a',
                    'visibility' => 'univ',
                ],
            ],
            [
                'action' => 'stage.transitioned',
                'target_type' => 'App\Models\Program',
                'target_id' => '1',
                'user_id' => $iqaOfficer->id,
                'college_id' => $colleges['CS']->id,
                'ip_address' => '192.168.10.15',
                'created_at' => $now->copy()->subDays(3)->setHour(14)->setMinute(30),
                'details' => [
                    'program' => 'BS Computer Science',
                    'level' => 'Level III Re-Accredited',
                    'previous' => ['stage' => 'preparatory'],
                    'updated' => ['stage' => 'self_survey_review'],
                ],
            ],
            [
                'action' => 'task_force.formed',
                'target_type' => 'App\Models\Program',
                'target_id' => '3',
                'user_id' => $deanCS->id,
                'college_id' => $colleges['CS']->id,
                'ip_address' => '192.168.10.45',
                'created_at' => $now->copy()->subDays(4)->setHour(9)->setMinute(45),
                'details' => [
                    'program' => 'BS Information Technology',
                    'chairperson' => 'Prof. Carlos Mendoza',
                    'encoder_count' => 12,
                    'area_count' => 10,
                ],
            ],
            [
                'action' => 'auth.role_assigned',
                'target_type' => 'App\Models\User',
                'target_id' => (string) $tfMemberCS->id,
                'user_id' => $sysAdmin->id,
                'college_id' => $colleges['CS']->id,
                'ip_address' => '192.168.1.100',
                'created_at' => $now->copy()->subDays(5)->setHour(16)->setMinute(10),
                'details' => [
                    'target_user' => $tfMemberCS->name,
                    'previous' => ['role' => 'faculty'],
                    'updated' => ['role' => 'task_force_member'],
                ],
            ],
            [
                'action' => 'document.downloaded',
                'target_type' => 'App\Models\Document',
                'target_id' => '82',
                'user_id' => $iqaOfficer->id,
                'college_id' => $colleges['CBEM']->id,
                'ip_address' => '192.168.30.14',
                'created_at' => $now->copy()->subDays(6)->setHour(11)->setMinute(22),
                'details' => [
                    'title' => 'CBEM Extension Community Engagement Portfolio.pdf',
                    'url_expires_in_minutes' => 15,
                    'reason' => 'External mock evaluation review',
                ],
            ],

            // --- PAST 8 - 30 DAYS ---
            [
                'action' => 'admin.instrument_uploaded',
                'target_type' => 'App\Models\Instrument',
                'target_id' => '1',
                'user_id' => $sysAdmin->id,
                'college_id' => null,
                'ip_address' => '192.168.1.100',
                'created_at' => $now->copy()->subDays(12)->setHour(13)->setMinute(0),
                'details' => [
                    'instrument' => 'AACCUP Revised Survey Instrument (2024 Master Edition)',
                    'areas_loaded' => 10,
                    'total_benchmarks' => 342,
                ],
            ],
            [
                'action' => 'accreditation.cycle_created',
                'target_type' => 'App\Models\Program',
                'target_id' => '1',
                'user_id' => $iqaOfficer->id,
                'college_id' => $colleges['CS']->id,
                'ip_address' => '192.168.10.15',
                'created_at' => $now->copy()->subDays(18)->setHour(10)->setMinute(30),
                'details' => [
                    'program' => 'BS Computer Science',
                    'target_level' => 'Level III Phase 1',
                    'scheduled_visit' => '2026-11-15',
                ],
            ],
            [
                'action' => 'auth.registered',
                'target_type' => 'App\Models\User',
                'target_id' => (string) $tfMemberCENG->id,
                'user_id' => $tfMemberCENG->id,
                'college_id' => $colleges['CENG']->id,
                'ip_address' => '192.168.20.88',
                'created_at' => $now->copy()->subDays(24)->setHour(8)->setMinute(15),
                'details' => [
                    'provider' => 'google',
                    'email' => $tfMemberCENG->email,
                    'status' => 'active',
                ],
            ],
            [
                'action' => 'admin.college_created',
                'target_type' => 'App\Models\College',
                'target_id' => (string) $colleges['CBEM']->id,
                'user_id' => $sysAdmin->id,
                'college_id' => null,
                'ip_address' => '192.168.1.100',
                'created_at' => $now->copy()->subDays(28)->setHour(9)->setMinute(0),
                'details' => [
                    'college_code' => 'CBEM',
                    'college_name' => 'College of Business, Economics & Management',
                    'campus' => 'Daraga Campus',
                ],
            ],
        ];

        // 4. Insert or update events idempotently
        foreach ($mockEvents as $event) {
            AuditLog::withoutGlobalScopes()->updateOrCreate(
                [
                    'action' => $event['action'],
                    'target_type' => $event['target_type'],
                    'target_id' => $event['target_id'],
                    'created_at' => $event['created_at'],
                ],
                [
                    'user_id' => $event['user_id'],
                    'college_id' => $event['college_id'],
                    'ip_address' => $event['ip_address'],
                    'details' => $event['details'],
                ]
            );
        }

        $this->command?->info('✓ Seeded ' . count($mockEvents) . ' realistic IQArchive compliance audit log events.');
    }
}
