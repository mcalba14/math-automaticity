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
        Schema::table('difficulty_levels', function (Blueprint $table) {
            $table->string('time_limit')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('difficulty_levels', function (Blueprint $table) {
            $table->dropColumn('time_limit');
        });
    }
};
