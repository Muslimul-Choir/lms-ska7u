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
        Schema::create('jadwal_belajar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_guru_mapel')->constrained('guru_mapel')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->enum('hari', ['Senin','Selasa','Rabu','Kamis','Jumat']);
            $table->foreignId('id_jam')->constrained('jam_belajar')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_kelas')
                  ->constrained('kelas')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwalbelajar');
    }
};
