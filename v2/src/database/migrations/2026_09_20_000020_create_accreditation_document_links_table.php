<?php

/**
 * ============================================================================
 * IQArchive v2 — Create Accreditation Document Links Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_20_000020_create_accreditation_document_links_table.php
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
        Schema::create('accreditation_document_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compliance_requirement_id')->constrained('compliance_requirements')->cascadeOnDelete();
            $table->foreignId('document_id')->constrained('documents')->cascadeOnDelete();
            $table->text('relevance_notes')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['compliance_requirement_id', 'document_id'], 'accred_doc_req_doc_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accreditation_document_links');
    }
};
