<?php

/**
 * ============================================================================
 * IQArchive v2 — Create Accreditations Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_20_000014_create_accreditations_table.php
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
        Schema::create('accreditations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->foreignId('task_force_id')->constrained('task_forces')->cascadeOnDelete();
            $table->string('applied_level', 50);
            $table->unsignedInteger('current_stage')->default(1);
            $table->enum('stage_status', ['in_progress', 'done', 'revision'])->default('in_progress');
            $table->date('target_date')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accreditations');
    }
};
