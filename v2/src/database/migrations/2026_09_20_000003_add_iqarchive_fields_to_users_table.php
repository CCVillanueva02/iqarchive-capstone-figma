<?php

/**
 * ============================================================================
 * IQArchive v2 — Add IQArchive Fields to Users Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_20_000003_add_iqarchive_fields_to_users_table.php
 * Schema Zone: Zone 1 (Multi-Tenancy & Access Control)
 * Design Ref: v2/docs/db-design/database-design.md
 * ============================================================================
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('college_id')->nullable()->after('id')->constrained('colleges')->nullOnDelete()->index();
            $table->string('google_id', 255)->nullable()->unique()->after('email');
            $table->string('avatar_url', 500)->nullable()->after('google_id');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('avatar_url');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['college_id']);
            $table->dropUnique(['google_id']);
            $table->dropColumn(['college_id', 'google_id', 'avatar_url', 'status']);
        });
    }
};
