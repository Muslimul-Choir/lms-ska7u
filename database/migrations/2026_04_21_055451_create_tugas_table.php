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
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pertemuan')->constrained('pertemuan')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_guru')->constrained('guru')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->string('judul', 200);
            $table->text('deskripsi')->nullable();
            $table->text('file_url')->nullable();
            $table->enum('tipe_tugas', ['individu', 'kelompok'])->default('individu');
            $table->dateTime('batas_waktu');
            $table->decimal('nilai_maksimal', 5, 2)->default(100.00);
            $table->enum('status', ['draft', 'published', 'closed'])->default('draft');
            $table->boolean('allow_late')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
