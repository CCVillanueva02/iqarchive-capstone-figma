<?php

/**
 * ============================================================================
 * IQArchive v2 — Create Colleges Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_20_000001_create_colleges_table.php
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
        Schema::create('colleges', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('code', 50)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('colleges');
    }
};
