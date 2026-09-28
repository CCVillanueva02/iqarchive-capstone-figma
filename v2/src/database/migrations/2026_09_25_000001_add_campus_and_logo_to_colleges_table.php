<?php

/**
 * ============================================================================
 * IQArchive v2 — Add Campus and Logo Image to Colleges Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_25_000001_add_campus_and_logo_to_colleges_table.php
 * Schema Zone: Zone 1 (Multi-Tenancy & Access Control)
 * Responsibility: Enriches colleges table with official campus location and logo asset.
 * ============================================================================
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            $table->string('campus', 100)->nullable()->after('name');
            $table->string('logo_image', 255)->nullable()->after('campus');
        });
    }

    public function down(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            $table->dropColumn(['campus', 'logo_image']);
        });
    }
};
