<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Seeder;

class AuditLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return;
        }

        // Seed realistic Access & Session logs (paired Login and Logout timestamps)
        foreach ($users->take(12) as $index => $uItem) {
            $loginTime = now()->subHours(fake()->numberBetween(1, 48));
            AuditLog::create([
                'user_id' => $uItem->id,
                'action' => 'login',
                'target_type' => User::class,
                'target_id' => $uItem->id,
                'timestamp' => $loginTime,
            ]);

            // 75% of logins have paired logout, 25% are Active Session
            if ($index % 4 !== 0) {
                AuditLog::create([
                    'user_id' => $uItem->id,
                    'action' => 'logout',
                    'target_type' => User::class,
                    'target_id' => $uItem->id,
                    'timestamp' => (clone $loginTime)->addMinutes(fake()->numberBetween(12, 180)),
                ]);
            }
        }

        // Seed Account Creation & Management audit logs
        $adminUserForAudit = $users->first();
        foreach ($users->skip(2)->take(6) as $uItem) {
            AuditLog::create([
                'user_id' => $adminUserForAudit->id,
                'action' => 'CREATE_USER',
                'target_type' => User::class,
                'target_id' => $uItem->id,
                'timestamp' => now()->subDays(fake()->numberBetween(1, 14)),
            ]);
        }

        // Seed File Modification audit logs
        foreach (range(1, 15) as $index) {
            $user = $users->random();
            $action = fake()->randomElement(['document_upload', 'document_approve', 'document_reject', 'document_update', 'document_delete']);

            AuditLog::create([
                'user_id' => $user->id,
                'action' => $action,
                'target_type' => Document::class,
                'target_id' => fake()->numberBetween(1, 50),
                'timestamp' => now()->subMinutes(fake()->numberBetween(10, 5000)),
            ]);
        }
    }
}
