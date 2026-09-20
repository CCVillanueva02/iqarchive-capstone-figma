<?php

/**
 * ============================================================================
 * IQArchive v2 — Create Instrument Criteria Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_20_000011_create_instrument_criteria_table.php
 * Schema Zone: Zone 2 (AACCUP Survey Instrument Master Hierarchy)
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
        Schema::create('instrument_criteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_parameter_id')->constrained('instrument_parameters')->cascadeOnDelete();
            $table->string('benchmark_code', 50);
            $table->text('title');
            $table->enum('type', ['system', 'impl', 'outcome']);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instrument_criteria');
    }
};
