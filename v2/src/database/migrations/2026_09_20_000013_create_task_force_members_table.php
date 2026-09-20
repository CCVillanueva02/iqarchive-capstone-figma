<?php

/**
 * ============================================================================
 * IQArchive v2 — Create Task Force Members Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_20_000013_create_task_force_members_table.php
 * Schema Zone: Zone 3 (Accreditation Pipeline & Task Force Management)
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
        Schema::create('task_force_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_force_id')->constrained('task_forces')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('instrument_area_id')->nullable()->constrained('instrument_areas')->nullOnDelete();
            $table->enum('role_in_team', ['lead', 'area_chair', 'member']);
            $table->timestamp('assigned_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_force_members');
    }
};
