<?php

/**
 * ============================================================================
 * IQArchive v2 — Create Instruments Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_20_000008_create_instruments_table.php
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
        Schema::create('instruments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('code', 50)->unique();
            $table->enum('type', ['ug', 'grad', 'inst']);
            $table->string('version', 20);
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instruments');
    }
};
