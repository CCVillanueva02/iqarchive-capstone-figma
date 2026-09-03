<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Security Reasoning: Accreditation visit records and their associated milestone
     * timestamps represent institutional audit history that must be preserved even if cancelled.
     */
    public function up(): void
    {
        if (Schema::hasTable('accreditations') && ! Schema::hasColumn('accreditations', 'deleted_at')) {
            Schema::table('accreditations', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('accreditations') && Schema::hasColumn('accreditations', 'deleted_at')) {
            Schema::table('accreditations', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
