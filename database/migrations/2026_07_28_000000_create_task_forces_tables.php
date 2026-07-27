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
        Schema::create('task_forces', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->unique();
            $table->foreignId('college_id')->constrained('colleges')->onDelete('cascade');
            $table->foreignId('program_id')->nullable()->constrained('programs')->onDelete('set null');
            $table->text('purpose')->nullable();
            $table->string('status')->default('active'); // active, completed, disbanded
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('task_force_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_force_id')->constrained('task_forces')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('role_in_team')->default('member'); // member, lead
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamps();

            $table->unique(['task_force_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_force_members');
        Schema::dropIfExists('task_forces');
    }
};
