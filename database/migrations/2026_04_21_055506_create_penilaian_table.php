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
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengumpulan_tugas')->constrained('pengumpulan_tugas')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_guru')
                  ->constrained('guru')->onUpdate('cascade');
            $table->decimal('nilai', 5, 2);
            $table->decimal('nilai_maksimal_snapshot', 5, 2);
            $table->text('catatan_guru')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
