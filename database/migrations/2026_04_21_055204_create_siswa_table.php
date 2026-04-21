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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->enum('agama', [
                'Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'
            ]);
            $table->foreignId('id_kelas')->constrained('kelas')->onUpdate('cascade');
            $table->foreignId('id_guru')->constrained('guru')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
