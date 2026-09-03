<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('roles')) {
            return;
        }

        // 1. Ensure 'iqa-staff' role exists
        $iqaStaff = DB::table('roles')->where('role_name', 'iqa-staff')->first();
        if (! $iqaStaff) {
            $iqaStaffId = DB::table('roles')->insertGetId([
                'role_name' => 'iqa-staff',
                'description' => 'IQA Staff',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $iqaStaffId = $iqaStaff->id;
        }

        // Find old IQA admin and IQA member role IDs
        $oldIqaRoleIds = DB::table('roles')
            ->whereIn('role_name', ['iqa-admin', 'iqa-member'])
            ->pluck('id')
            ->toArray();

        if (! empty($oldIqaRoleIds)) {
            // Update users having old IQA roles to iqa-staff
            DB::table('users')
                ->whereIn('role_id', $oldIqaRoleIds)
                ->update(['role_id' => $iqaStaffId]);

            // Update role_user entries
            if (Schema::hasTable('role_user')) {
                foreach ($oldIqaRoleIds as $oldRoleId) {
                    $userIds = DB::table('role_user')
                        ->where('role_id', $oldRoleId)
                        ->pluck('user_id');

                    foreach ($userIds as $userId) {
                        DB::table('role_user')->insertOrIgnore([
                            'user_id' => $userId,
                            'role_id' => $iqaStaffId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                    DB::table('role_user')->where('role_id', $oldRoleId)->delete();
                }
            }

            // Remove old roles from roles table
            DB::table('roles')->whereIn('id', $oldIqaRoleIds)->delete();
        }

        // Remove 'task-force' and 'program-chair' roles
        $deprecatedRoles = DB::table('roles')
            ->whereIn('role_name', ['task-force', 'program-chair'])
            ->pluck('id')
            ->toArray();

        if (! empty($deprecatedRoles)) {
            if (Schema::hasTable('role_user')) {
                DB::table('role_user')->whereIn('role_id', $deprecatedRoles)->delete();
            }

            // Fallback user primary role_id if they held deprecated roles
            $defaultRole = DB::table('roles')->where('role_name', 'task-force-member')->first()
                ?? DB::table('roles')->where('role_name', 'college-head')->first();

            if ($defaultRole) {
                DB::table('users')
                    ->whereIn('role_id', $deprecatedRoles)
                    ->update(['role_id' => $defaultRole->id]);
            }

            DB::table('roles')->whereIn('id', $deprecatedRoles)->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Non-destructive rollback notice
    }
};
