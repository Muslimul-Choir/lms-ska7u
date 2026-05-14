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
        Schema::table('materi', function (Blueprint $table) {
            $table->foreignId('id_mapel')->nullable()->constrained('mapel')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_guru_mapel')->nullable()->constrained('guru_mapel')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('tugas', function (Blueprint $table) {
            $table->foreignId('id_mapel')->nullable()->constrained('mapel')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_guru_mapel')->nullable()->constrained('guru_mapel')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materi', function (Blueprint $table) {
            $table->dropForeign(['id_mapel']);
            $table->dropForeign(['id_guru_mapel']);
            $table->dropColumn(['id_mapel', 'id_guru_mapel']);
        });

        Schema::table('tugas', function (Blueprint $table) {
            $table->dropForeign(['id_mapel']);
            $table->dropForeign(['id_guru_mapel']);
            $table->dropColumn(['id_mapel', 'id_guru_mapel']);
        });
    }
};
