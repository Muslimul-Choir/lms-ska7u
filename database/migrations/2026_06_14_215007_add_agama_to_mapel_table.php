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
        Schema::table('mapel', function (Blueprint $table) {
            // Tambah kolom agama (nullable untuk mapel umum)
            // Jika null = mapel umum untuk semua siswa
            // Jika diisi = mapel khusus untuk agama tertentu (contoh: Islam, Kristen, Katolik, Hindu, Buddha, Konghucu)
            $table->string('agama', 50)->nullable()->after('nama_mapel');
            $table->index('agama'); // Index untuk performa query
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mapel', function (Blueprint $table) {
            $table->dropIndex(['agama']);
            $table->dropColumn('agama');
        });
    }
};
