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
        Schema::create('hasil_kuis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kuis')->constrained('kuis')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_siswa')->constrained('siswa')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->json('jawaban')->nullable(); // {"1":"A","2":"C",...} (nomor_soal → pilihan)
            $table->decimal('nilai', 5, 2)->nullable(); // NULL sampai submit
            $table->unsignedSmallInteger('jumlah_benar')->nullable();
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai')->nullable(); // NULL sampai submit
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_kuis');
    }
};
