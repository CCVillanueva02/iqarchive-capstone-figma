<?php

/**
 * ============================================================================
 * IQArchive v2 — Create Task Forces Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_20_000012_create_task_forces_table.php
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
        Schema::create('task_forces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->foreignId('dean_lead_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('academic_year', 20);
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_forces');
    }
};
