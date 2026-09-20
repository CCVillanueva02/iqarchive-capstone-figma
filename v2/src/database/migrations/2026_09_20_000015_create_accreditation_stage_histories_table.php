<?php

/**
 * ============================================================================
 * IQArchive v2 — Create Accreditation Stage Histories Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_20_000015_create_accreditation_stage_histories_table.php
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
        Schema::create('accreditation_stage_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accreditation_id')->constrained('accreditations')->cascadeOnDelete();
            $table->unsignedInteger('from_stage')->nullable();
            $table->unsignedInteger('to_stage');
            $table->foreignId('initiated_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by')->constrained('users')->cascadeOnDelete();
            $table->text('remarks')->nullable();
            $table->timestamp('transitioned_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accreditation_stage_histories');
    }
};
