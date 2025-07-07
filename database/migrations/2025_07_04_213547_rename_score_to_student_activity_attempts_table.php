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
            $table->foreignId('lesson_id')->references('id')->on('lessons')->onDelete('cascade')->after('student_id');
            $table->renameColumn('score', 'student_answer');
            $table->string('student_answer')->change();
            $table->dropColumn('accuracy');
            $table->dropColumn('duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_activity_attempts', function (Blueprint $table) {
            $table->dropForeign(['lesson_id']);
            $table->dropColumn('lesson_id');
            $table->renameColumn('student_answer', 'score');
            $table->integer('score')->change();
            $table->float('accuracy')->nullable();
            $table->integer('duration')->nullable();
        });
    }
};
