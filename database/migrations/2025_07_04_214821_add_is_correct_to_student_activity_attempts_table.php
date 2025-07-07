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
        Schema::table('student_activity_attempts', function (Blueprint $table) {
            $table->boolean('is_correct')->after('student_answer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_activity_attempts', function (Blueprint $table) {
            $table->dropColumn('is_correct');
        });
    }
};
