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
        if (Schema::hasTable('colleges') && !Schema::hasColumn('colleges', 'campus')) {
            Schema::table('colleges', function (Blueprint $table) {
                $table->string('campus')->default('Main Campus')->after('code');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('colleges') && Schema::hasColumn('colleges', 'campus')) {
            Schema::table('colleges', function (Blueprint $table) {
                $table->dropColumn('campus');
            });
        }
    }
};
