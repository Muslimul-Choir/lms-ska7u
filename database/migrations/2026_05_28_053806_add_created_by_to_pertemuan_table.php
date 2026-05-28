<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pertemuan', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('id_guru');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        DB::table('pertemuan')
            ->join('jadwal_belajar', 'pertemuan.id_jadwal', '=', 'jadwal_belajar.id')
            ->join('guru_mapel', 'jadwal_belajar.id_guru_mapel', '=', 'guru_mapel.id')
            ->join('guru', 'guru_mapel.id_guru', '=', 'guru.id')
            ->update(['pertemuan.created_by' => DB::raw('guru.id_user')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pertemuan', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
    }
};
