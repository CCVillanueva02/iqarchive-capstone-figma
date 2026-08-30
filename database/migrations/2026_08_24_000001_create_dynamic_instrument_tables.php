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
        // 1. Add fields to existing instruments table if they don't exist
        Schema::table('instruments', function (Blueprint $table) {
            if (!Schema::hasColumn('instruments', 'accreditation_type')) {
                $table->string('accreditation_type')->default('program')->after('code');
            }
            if (!Schema::hasColumn('instruments', 'program_id')) {
                $table->foreignId('program_id')->nullable()->after('accreditation_type')->constrained('programs')->nullOnDelete();
            }
            if (!Schema::hasColumn('instruments', 'accreditation_id')) {
                $table->foreignId('accreditation_id')->nullable()->after('program_id')->constrained('accreditations')->nullOnDelete();
            }
            if (!Schema::hasColumn('instruments', 'is_template')) {
                $table->boolean('is_template')->default(true)->after('accreditation_id');
            }
            if (!Schema::hasColumn('instruments', 'version')) {
                $table->string('version')->default('2026.1')->after('level');
            }
            if (!Schema::hasColumn('instruments', 'status')) {
                $table->string('status')->default('active')->after('version'); // draft, active, archived
            }
            if (!Schema::hasColumn('instruments', 'created_by')) {
                $table->foreignId('created_by')->nullable()->after('status')->constrained('users')->nullOnDelete();
            }
        });

        // 2. Add order, weight, description to instrument_areas
        Schema::table('instrument_areas', function (Blueprint $table) {
            if (!Schema::hasColumn('instrument_areas', 'order')) {
                $table->integer('order')->default(1)->after('code');
            }
            if (!Schema::hasColumn('instrument_areas', 'weight')) {
                $table->decimal('weight', 5, 2)->nullable()->after('order');
            }
            if (!Schema::hasColumn('instrument_areas', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
        });

        // 3. Create instrument_parameters table
        if (!Schema::hasTable('instrument_parameters')) {
            Schema::create('instrument_parameters', function (Blueprint $table) {
                $table->id();
                $table->foreignId('instrument_area_id')->constrained('instrument_areas')->cascadeOnDelete();
                $table->string('code'); // e.g. "Parameter A", "Parameter B"
                $table->string('name'); // e.g. "Statement of VMGO"
                $table->text('description')->nullable();
                $table->integer('order')->default(1);
                $table->decimal('weight', 5, 2)->nullable();
                $table->timestamps();
            });
        }

        // 4. Create instrument_criteria table (Checklist criteria with 4 standard sections and required tags)
        if (!Schema::hasTable('instrument_criteria')) {
            Schema::create('instrument_criteria', function (Blueprint $table) {
                $table->id();
                $table->foreignId('instrument_parameter_id')->constrained('instrument_parameters')->cascadeOnDelete();
                $table->string('section')->default('systems'); // systems, implementation, outcomes, best_practices
                $table->string('code'); // e.g. "S.1", "I.1", "O.1", "BP.1"
                $table->text('statement'); // Statement / guideline description
                $table->text('description')->nullable();
                $table->json('required_tags')->nullable(); // e.g. ["#UniversityManual", "#BoardResolution"]
                $table->integer('order')->default(1);
                $table->timestamps();
            });
        }

        // 5. Enhance compliance_requirements to link with instrument_criterion_id & accreditation_id
        Schema::table('compliance_requirements', function (Blueprint $table) {
            if (!Schema::hasColumn('compliance_requirements', 'accreditation_id')) {
                $table->foreignId('accreditation_id')->nullable()->after('program_id')->constrained('accreditations')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('compliance_requirements', 'instrument_criterion_id')) {
                $table->foreignId('instrument_criterion_id')->nullable()->after('instrument_id')->constrained('instrument_criteria')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compliance_requirements', function (Blueprint $table) {
            if (Schema::hasColumn('compliance_requirements', 'instrument_criterion_id')) {
                $table->dropForeign(['instrument_criterion_id']);
                $table->dropColumn('instrument_criterion_id');
            }
            if (Schema::hasColumn('compliance_requirements', 'accreditation_id')) {
                $table->dropForeign(['accreditation_id']);
                $table->dropColumn('accreditation_id');
            }
        });

        Schema::dropIfExists('instrument_criteria');
        Schema::dropIfExists('instrument_parameters');

        Schema::table('instrument_areas', function (Blueprint $table) {
            if (Schema::hasColumn('instrument_areas', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('instrument_areas', 'weight')) {
                $table->dropColumn('weight');
            }
            if (Schema::hasColumn('instrument_areas', 'order')) {
                $table->dropColumn('order');
            }
        });

        Schema::table('instruments', function (Blueprint $table) {
            if (Schema::hasColumn('instruments', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('instruments', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('instruments', 'version')) {
                $table->dropColumn('version');
            }
            if (Schema::hasColumn('instruments', 'is_template')) {
                $table->dropColumn('is_template');
            }
            if (Schema::hasColumn('instruments', 'accreditation_id')) {
                $table->dropForeign(['accreditation_id']);
                $table->dropColumn('accreditation_id');
            }
            if (Schema::hasColumn('instruments', 'program_id')) {
                $table->dropForeign(['program_id']);
                $table->dropColumn('program_id');
            }
            if (Schema::hasColumn('instruments', 'accreditation_type')) {
                $table->dropColumn('accreditation_type');
            }
        });
    }
};
