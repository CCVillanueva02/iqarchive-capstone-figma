<?php

/**
 * ============================================================================
 * IQArchive v2 — Create Instrument Parameters Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_20_000010_create_instrument_parameters_table.php
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
        Schema::create('instrument_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_area_id')->constrained('instrument_areas')->cascadeOnDelete();
            $table->string('parameter_letter', 10);
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instrument_parameters');
    }
};
