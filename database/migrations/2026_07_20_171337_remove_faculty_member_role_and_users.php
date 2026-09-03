<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
    public function up(): void
    {
        $role = \Illuminate\Support\Facades\DB::table('roles')->where('role_name', 'faculty-member')->first();
        if ($role) {
            // Delete users with this role
            \Illuminate\Support\Facades\DB::table('users')->where('role_id', $role->id)->delete();
            // Delete the role
            \Illuminate\Support\Facades\DB::table('roles')->where('id', $role->id)->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
