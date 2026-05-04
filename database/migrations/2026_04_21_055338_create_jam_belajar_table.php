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
    Schema::create('jam_belajar', function (Blueprint $table) {
        $table->id();
        $table->time('jam_mulai');
        $table->time('jam_selesai');

        // Tambahan sesuai model
        $table->unsignedBigInteger('id_tingkatan');

        // Foreign key (relasi ke tabel tingkatan)
        $table->foreign('id_tingkatan')
              ->references('id')
              ->on('tingkatan')
              ->onDelete('cascade');

        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jam_belajar');
    }
};
