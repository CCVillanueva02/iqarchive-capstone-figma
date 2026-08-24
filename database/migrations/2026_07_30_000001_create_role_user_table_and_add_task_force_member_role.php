<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create role_user pivot table
        if (!Schema::hasTable('role_user')) {
            Schema::create('role_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['user_id', 'role_id']);
            });
        }

        // 2. Add task-force-member role and update task-force description if roles table exists
        if (Schema::hasTable('roles')) {
            $taskForceLead = DB::table('roles')->where('role_name', 'task-force')->first();
            if ($taskForceLead) {
                DB::table('roles')->where('id', $taskForceLead->id)->update([
                    'description' => 'Task Force Lead',
                ]);
            }

            $hasMemberRole = DB::table('roles')->where('role_name', 'task-force-member')->exists();
            if (!$hasMemberRole) {
                DB::table('roles')->insert([
                    'role_name' => 'task-force-member',
                    'description' => 'Task Force Member',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 3. Migrate existing user roles into role_user pivot table
        if (Schema::hasTable('users') && Schema::hasTable('role_user')) {
            $users = DB::table('users')->whereNotNull('role_id')->get();
            foreach ($users as $user) {
                DB::table('role_user')->insertOrIgnore([
                    'user_id' => $user->id,
                    'role_id' => $user->role_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
        DB::table('roles')->where('role_name', 'task-force-member')->delete();
    }
};
