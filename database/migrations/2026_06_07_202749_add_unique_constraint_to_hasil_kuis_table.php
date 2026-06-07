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
        Schema::table('hasil_kuis', function (Blueprint $table) {
            // Add unique constraint to prevent duplicate quiz attempts
            $table->unique(['id_kuis', 'id_siswa'], 'unique_quiz_attempt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_kuis', function (Blueprint $table) {
            $table->dropUnique('unique_quiz_attempt');
        });
    }
};
