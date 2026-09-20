<?php

/**
 * ============================================================================
 * IQArchive v2 — Create Document Reviews Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_20_000022_create_document_reviews_table.php
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
        Schema::create('document_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('review_stage', ['dean', 'iqa', 'internal_accreditor']);
            $table->enum('decision', ['approved', 'rejected', 'advisory']);
            $table->text('remarks')->nullable();
            $table->timestamp('reviewed_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_reviews');
    }
};
