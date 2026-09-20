<?php

/**
 * ============================================================================
 * IQArchive v2 — Create Document Categories Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_20_000018_create_document_categories_table.php
 * Schema Zone: Zone 4 (Evidence Document Storage, Review & OCR Engine)
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
        Schema::create('document_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->enum('scope', ['institutional', 'college', 'program']);
            $table->text('description')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_categories');
    }
};
