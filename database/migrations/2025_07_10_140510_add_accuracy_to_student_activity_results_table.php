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
        Schema::table('student_activity_results', function (Blueprint $table) {
            $table->foreignId('lesson_id')
                ->references('id')
                ->on('lessons')
                ->cascadeOnDelete()
                ->after('attempt_id');
            $table->integer('accuracy')
                ->default(0)
                ->after('total_correct')
                ->comment('Percentage of correct answers in the activity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_activity_results', function (Blueprint $table) {
            $table->dropForeign(['lesson_id']);
            $table->dropColumn('lesson_id');
            $table->dropColumn('accuracy');
        });
    }
};
