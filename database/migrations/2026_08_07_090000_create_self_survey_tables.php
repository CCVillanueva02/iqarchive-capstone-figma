<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Creates tables to store institutional self-survey area data,
     * parameters, indicators, and item ratings.
     */
    public function up(): void
    {
        // Self-survey areas (Area I – IX for institutional)
        Schema::create('self_survey_areas', function (Blueprint $table) {
            $table->id();
            $table->string('code');        // 'area_i1' ... 'area_i9'
            $table->string('label');       // 'Area I', 'Area II', ...
            $table->string('title');       // 'Governance and Management', etc.
            $table->string('type')->default('institutional'); // institutional / program
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Self-survey parameters per area (Parameter A, B, C …)
        Schema::create('self_survey_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained('self_survey_areas')->onDelete('cascade');
            $table->string('code');   // 'A', 'B', 'C'
            $table->string('title');  // 'Governance – Organizational Structure'
            $table->text('best_practices')->nullable(); // stores best practices text input
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Individual indicator rows per parameter, grouped by section
        Schema::create('self_survey_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parameter_id')->constrained('self_survey_parameters')->onDelete('cascade');
            $table->string('section');     // 'system', 'implementation', 'outcome'
            $table->string('code');        // 'S.1', 'I.1', 'O.1'
            $table->text('statement');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // IR rating values per indicator, keyed by user (evaluator)
        Schema::create('self_survey_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indicator_id')->constrained('self_survey_indicators')->onDelete('cascade');
            $table->foreignId('rated_by')->constrained('users')->onDelete('cascade');
            $table->unsignedTinyInteger('rating')->nullable(); // 0-5 (null = NA)
            $table->timestamps();

            $table->unique(['indicator_id', 'rated_by']); // one rating per user per indicator
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('self_survey_ratings');
        Schema::dropIfExists('self_survey_indicators');
        Schema::dropIfExists('self_survey_parameters');
        Schema::dropIfExists('self_survey_areas');
    }
};
