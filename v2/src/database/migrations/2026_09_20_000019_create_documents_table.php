<?php

/**
 * ============================================================================
 * IQArchive v2 — Create Documents Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_20_000019_create_documents_table.php
 * Schema Zone: Zone 4 (Evidence Document Storage, Review & OCR Engine)
 * Design Ref: v2/docs/db-design/database-design.md
 * Multi-Tenancy Scoping: Every query scopes by college_id
 * ============================================================================
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_id')->nullable()->constrained('colleges')->cascadeOnDelete();
            $table->foreignId('program_id')->nullable()->constrained('programs')->nullOnDelete();
            $table->foreignId('category_id')->constrained('document_categories')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title', 255);
            $table->string('original_filename', 255);
            $table->string('file_path', 500);
            $table->string('file_hash', 64)->index();
            $table->unsignedBigInteger('file_size_bytes');
            $table->string('mime_type', 100);
            $table->enum('status', ['draft', 'dean_appr', 'iqa_appr', 'rejected'])->default('draft');
            $table->enum('visibility', ['private', 'college', 'univ', 'accreditor'])->default('college');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
