<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('document_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('program_id')->nullable()->constrained('programs')->onDelete('set null');
            $table->foreignId('category_id')->constrained('document_categories')->onDelete('restrict');
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('confirmed_at')->nullable();
            $table->string('title');
            $table->string('file_path');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->string('visibility')->default('restricted'); // public, restricted
            $table->timestamps();
        });

        Schema::create('document_ocr_validations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
            $table->foreignId('validated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->longText('extracted_data')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->string('validation_status')->default('pending'); // pending, validated, failed
            $table->timestamps();
        });

        Schema::create('document_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
            $table->foreignId('reviewed_by')->constrained('users')->onDelete('cascade');
            $table->string('decision'); // approved, rejected
            $table->text('remarks')->nullable();
            $table->timestamp('reviewed_at')->useCurrent();
            $table->timestamps();
        });

        Schema::create('instruments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->nullable()->constrained('documents')->onDelete('set null');
            $table->string('name');
            $table->string('code')->unique();
            $table->string('level')->nullable(); // Level I, Level II, etc.
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('instrument_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_id')->constrained('instruments')->onDelete('cascade');
            $table->string('name');
            $table->string('code');
            $table->timestamps();
        });

        Schema::create('compliance_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_id')->constrained('instruments')->onDelete('cascade');
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->string('status')->default('pending'); // pending, in_progress, complied, overdue
            $table->timestamps();
        });

        Schema::create('accreditation_document_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
            $table->foreignId('compliance_requirement_id')->constrained('compliance_requirements')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('task_force_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->timestamp('assigned_at')->useCurrent();
            $table->string('status')->default('active'); // active, completed
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('related_document_id')->nullable()->constrained('documents')->onDelete('set null');
            $table->string('type'); // info, alert, etc.
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('action');
            $table->string('target_type')->nullable();
            $table->unsignedBigInteger('target_id')->nullable();
            $table->timestamp('timestamp')->useCurrent();
        });

        Schema::create('document_access_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
            $table->foreignId('requested_by')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('remarks')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_access_requests');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('task_force_assignments');
        Schema::dropIfExists('accreditation_document_links');
        Schema::dropIfExists('compliance_requirements');
        Schema::dropIfExists('instrument_areas');
        Schema::dropIfExists('instruments');
        Schema::dropIfExists('document_reviews');
        Schema::dropIfExists('document_ocr_validations');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('document_categories');
    }
};
