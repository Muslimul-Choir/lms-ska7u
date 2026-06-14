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
        // Add image field to kuis table
        Schema::table('kuis', function (Blueprint $table) {
            $table->string('cover_image')->nullable()->after('deskripsi');
        });

        // Add image field to soal_kuis table
        Schema::table('soal_kuis', function (Blueprint $table) {
            $table->string('gambar_soal')->nullable()->after('pertanyaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuis', function (Blueprint $table) {
            $table->dropColumn('cover_image');
        });

        Schema::table('soal_kuis', function (Blueprint $table) {
            $table->dropColumn('gambar_soal');
        });
    }
};
