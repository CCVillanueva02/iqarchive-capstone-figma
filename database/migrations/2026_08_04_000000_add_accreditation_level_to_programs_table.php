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
        if (Schema::hasTable('programs') && !Schema::hasColumn('programs', 'accreditation_level')) {
            Schema::table('programs', function (Blueprint $table) {
                $table->string('accreditation_level')->default('Candidate Status')->after('code');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('programs') && Schema::hasColumn('programs', 'accreditation_level')) {
            Schema::table('programs', function (Blueprint $table) {
                $table->dropColumn('accreditation_level');
            });
        }
    }
};
