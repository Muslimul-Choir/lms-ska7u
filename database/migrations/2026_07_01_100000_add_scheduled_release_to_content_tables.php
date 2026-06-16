<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add scheduled release fields to materi, tugas, and kuis tables
     */
    public function up(): void
    {
        // Add scheduled release fields to materi table
        Schema::table('materi', function (Blueprint $table) {
            $table->dateTime('waktu_rilis')->nullable()->after('tipe_materi')
                  ->comment('Content release time - when content becomes visible to students');
            $table->dateTime('batas_absensi')->nullable()->after('waktu_rilis')
                  ->comment('Attendance deadline - students must mark attendance before accessing content');
            $table->boolean('auto_release')->default(true)->after('batas_absensi')
                  ->comment('Auto-calculate release time from pertemuan schedule');
            
            // Add index for performance on time-based queries
            $table->index('waktu_rilis', 'idx_materi_waktu_rilis');
        });

        // Add scheduled release fields to tugas table
        Schema::table('tugas', function (Blueprint $table) {
            $table->dateTime('waktu_rilis')->nullable()->after('status')
                  ->comment('Content release time - when content becomes visible to students');
            $table->dateTime('batas_absensi')->nullable()->after('waktu_rilis')
                  ->comment('Attendance deadline - students must mark attendance before accessing content');
            $table->boolean('auto_release')->default(true)->after('batas_absensi')
                  ->comment('Auto-calculate release time from pertemuan schedule');
            
            // Add index for performance
            $table->index('waktu_rilis', 'idx_tugas_waktu_rilis');
            $table->index('batas_waktu', 'idx_tugas_batas_waktu');
        });

        // Add scheduled release fields to kuis table
        Schema::table('kuis', function (Blueprint $table) {
            $table->dateTime('waktu_rilis')->nullable()->after('status')
                  ->comment('Content release time - when content becomes visible to students');
            $table->dateTime('batas_absensi')->nullable()->after('waktu_rilis')
                  ->comment('Attendance deadline - students must mark attendance before accessing content');
            $table->boolean('auto_release')->default(true)->after('batas_absensi')
                  ->comment('Auto-calculate release time from pertemuan schedule');
            
            // Add index for performance
            $table->index('waktu_rilis', 'idx_kuis_waktu_rilis');
            $table->index('batas_mulai', 'idx_kuis_batas_mulai');
            $table->index('batas_selesai', 'idx_kuis_batas_selesai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materi', function (Blueprint $table) {
            $table->dropIndex('idx_materi_waktu_rilis');
            $table->dropColumn(['waktu_rilis', 'batas_absensi', 'auto_release']);
        });

        Schema::table('tugas', function (Blueprint $table) {
            $table->dropIndex('idx_tugas_waktu_rilis');
            $table->dropIndex('idx_tugas_batas_waktu');
            $table->dropColumn(['waktu_rilis', 'batas_absensi', 'auto_release']);
        });

        Schema::table('kuis', function (Blueprint $table) {
            $table->dropIndex('idx_kuis_waktu_rilis');
            $table->dropIndex('idx_kuis_batas_mulai');
            $table->dropIndex('idx_kuis_batas_selesai');
            $table->dropColumn(['waktu_rilis', 'batas_absensi', 'auto_release']);
        });
    }
};
