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
        Schema::create('guru_mapel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_mapel')->constrained('mapel')->onUpdate('cascade');
            $table->foreignId('id_guru')->constrained('guru')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_kelas')->constrained('kelas')->onUpdate('cascade');
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
        Schema::dropIfExists('guru_mapel');
    }
};
