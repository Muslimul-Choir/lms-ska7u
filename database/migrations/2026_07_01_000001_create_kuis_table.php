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
        Schema::create('kuis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pertemuan')->constrained('pertemuan')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_guru_mapel')->constrained('guru_mapel')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_guru')->constrained('guru')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->string('judul', 200);
            $table->text('deskripsi')->nullable();
            $table->unsignedSmallInteger('durasi'); // dalam menit
            $table->decimal('nilai_maksimal', 5, 2)->default(100.00);
            $table->dateTime('batas_mulai');
            $table->dateTime('batas_selesai');
            $table->enum('status', ['draft', 'published', 'closed'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuis');
    }
};
