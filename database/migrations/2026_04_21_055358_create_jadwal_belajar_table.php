<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_belajar', function (Blueprint $table) {
            $table->id();

            // Nullable karena bisa jadi kegiatan (Istirahat, Upacara) bukan mapel
            $table->foreignId('id_guru_mapel')
                  ->nullable()
                  ->constrained('guru_mapel')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            // Relasi langsung ke mapel (opsional, untuk ambil nama mapel tanpa lewat guru_mapel)
            $table->foreignId('id_mapel')
                  ->nullable()
                  ->constrained('mapel')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            $table->enum('hari', [
                'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'
            ]);

            $table->foreignId('id_jam')
                  ->constrained('jam_belajar')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreignId('id_kelas')
                  ->constrained('kelas')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            // Untuk kegiatan non-mapel seperti "Istirahat", "Upacara"
            $table->string('nama_kegiatan')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_belajar');
    }
};