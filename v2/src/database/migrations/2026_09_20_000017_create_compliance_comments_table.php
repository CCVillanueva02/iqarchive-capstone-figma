<?php

/**
 * ============================================================================
 * IQArchive v2 — Create Compliance Comments Table Migration
 * ============================================================================
 * File: database/migrations/2026_09_20_000017_create_compliance_comments_table.php
 * Schema Zone: Zone 3 (Accreditation Pipeline & Task Force Management)
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
        Schema::create('compliance_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compliance_requirement_id')->constrained('compliance_requirements')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('comment_type', ['advisory', 'gap', 'clarification']);
            $table->text('comment_text');
            $table->boolean('is_resolved')->default(false);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compliance_comments');
    }
};
