<?php

/**
 * ============================================================================
 * IQArchive v2 — Create Programs Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_20_000002_create_programs_table.php
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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_id')->constrained('colleges')->cascadeOnDelete();
            $table->string('name', 255);
            $table->string('code', 50)->unique();
            $table->string('current_level', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
