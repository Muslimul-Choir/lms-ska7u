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
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')
                  ->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('aksi', ['CREATE','UPDATE','DELETE','LOGIN','LOGOUT','VIEW']);
            $table->string('modul', 100)->nullable();
            $table->string('tabel_target', 100)->nullable();
            $table->unsignedBigInteger('id_target')->nullable();
            $table->string('deskripsi', 500)->nullable();
            $table->enum('status_aksi', ['sukses','gagal'])->default('sukses');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 300)->nullable();
            $table->string('session_id', 128)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_log');
    }
};
