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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tingkatan')->constrained('tingkatan')->onUpdate('cascade');
            $table->foreignId('id_jurusan')->constrained('jurusan')->onUpdate('cascade');
            $table->foreignId('id_bagian')->constrained('bagian')->onUpdate('cascade');
            $table->foreignId('id_tahun_ajaran')->constrained('tahun_ajaran')->onUpdate('cascade');
            $table->foreignId('id_semester')->constrained('semester')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
