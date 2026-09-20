<?php

/**
 * ============================================================================
 * IQArchive v2 — Create OCR Results Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_20_000021_create_ocr_results_table.php
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
        Schema::create('ocr_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->unique()->constrained('documents')->cascadeOnDelete();
            $table->foreignId('validated_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->longText('raw_text');
            $table->longText('edited_text')->nullable();
            $table->json('confidence_metrics');
            $table->json('pages_data');
            $table->decimal('average_confidence', 5, 4);
            $table->enum('status', ['processing', 'completed', 'validated'])->default('processing');
            $table->unsignedInteger('duration_ms');
            $table->timestamp('validated_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ocr_results');
    }
};
