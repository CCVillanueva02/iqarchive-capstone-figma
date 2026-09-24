<?php

/**
 * ============================================================================
 * IQArchive v2 — Create Compliance Requirements Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_20_000016_create_compliance_requirements_table.php
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
        Schema::create('compliance_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accreditation_id')->constrained('accreditations')->cascadeOnDelete();
            $table->foreignId('instrument_criteria_id')->constrained('instrument_criteria')->cascadeOnDelete();
            $table->enum('status', ['unassigned', 'in_progress', 'compliant'])->default('unassigned');
            $table->date('due_date')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['accreditation_id', 'instrument_criteria_id'], 'comp_req_accred_crit_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compliance_requirements');
    }
};
