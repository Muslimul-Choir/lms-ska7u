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
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->string('nama_lengkap', 150);
            $table->enum('status_pengajar', ['pengajar', 'walikelas', 'keduanya'])
                  ->default('pengajar');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};
