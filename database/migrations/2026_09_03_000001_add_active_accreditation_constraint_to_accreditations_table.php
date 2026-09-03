<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Security Reasoning & Invariant: Enforce at the database level that a degree program
     * can only have at most ONE active accreditation cycle at any given time.
     * Historical completed and cancelled accreditations evaluate to NULL and remain unrestricted.
     */
    public function up(): void
    {
        if (Schema::hasTable('accreditations') && ! Schema::hasColumn('accreditations', 'active_program_id')) {
            Schema::table('accreditations', function (Blueprint $table) {
                $table->unsignedBigInteger('active_program_id')
                    ->nullable()
                    ->virtualAs("CASE WHEN status NOT IN ('completed', 'cancelled') THEN program_id ELSE NULL END");
                $table->unique('active_program_id', 'accreditations_active_program_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('accreditations') && Schema::hasColumn('accreditations', 'active_program_id')) {
            Schema::table('accreditations', function (Blueprint $table) {
                $table->dropUnique('accreditations_active_program_unique');
                $table->dropColumn('active_program_id');
            });
        }
    }
};
