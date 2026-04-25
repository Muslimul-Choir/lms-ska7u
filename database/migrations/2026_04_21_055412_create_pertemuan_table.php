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
        Schema::create('pertemuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_jadwal')->constrained('jadwalbelajar')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedTinyInteger('nomor_pertemuan')->default(1);
            $table->date('tanggal')->nullable();
            $table->enum('status', ['dijadwalkan','berlangsung','selesai','dibatalkan'])->default('dijadwalkan');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertemuan');
    }
};
