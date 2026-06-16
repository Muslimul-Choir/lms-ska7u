<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add fields for content-based attendance tracking
     */
    public function up(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            // Check and add columns only if they don't exist
            if (!Schema::hasColumn('absensi', 'tipe_konten')) {
                $table->string('tipe_konten')->nullable()->after('id_pertemuan')
                      ->comment('Type of content: pertemuan, materi, tugas, kuis');
            }
            
            if (!Schema::hasColumn('absensi', 'id_konten')) {
                $table->unsignedBigInteger('id_konten')->nullable()->after('tipe_konten')
                      ->comment('ID of the content (materi_id, tugas_id, or kuis_id)');
            }
            
            if (!Schema::hasColumn('absensi', 'batas_waktu_absen')) {
                $table->dateTime('batas_waktu_absen')->nullable()->after('status')
                      ->comment('Deadline for marking attendance');
            }
            
            if (!Schema::hasColumn('absensi', 'status_keterlambatan')) {
                $table->enum('status_keterlambatan', ['tepat_waktu', 'terlambat', 'sangat_terlambat'])
                      ->nullable()->after('keterangan')
                      ->comment('Lateness status');
            }
        });

        $isSqlite = DB::getDriverName() === 'sqlite';

        // Add indexes if they don't exist
        $indexes = $isSqlite
            ? DB::select("SELECT name FROM sqlite_master WHERE type='index' AND tbl_name='absensi' AND name='idx_absensi_content'")
            : DB::select("SHOW INDEX FROM absensi WHERE Key_name = 'idx_absensi_content'");
        if (empty($indexes)) {
            Schema::table('absensi', function (Blueprint $table) {
                $table->index(['tipe_konten', 'id_konten'], 'idx_absensi_content');
            });
        }

        $indexes = $isSqlite
            ? DB::select("SELECT name FROM sqlite_master WHERE type='index' AND tbl_name='absensi' AND name='idx_absensi_batas'")
            : DB::select("SHOW INDEX FROM absensi WHERE Key_name = 'idx_absensi_batas'");
        if (empty($indexes)) {
            Schema::table('absensi', function (Blueprint $table) {
                $table->index('batas_waktu_absen', 'idx_absensi_batas');
            });
        }

        // Create content exemptions table if not exists
        if (!Schema::hasTable('content_exemptions')) {
            Schema::create('content_exemptions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_siswa')->constrained('siswa')
                      ->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('id_guru')->nullable()->constrained('guru')
                      ->onUpdate('cascade')->onDelete('set null')
                      ->comment('Guru who granted the exemption');
                
                // Polymorphic relation for content
                $table->string('tipe_konten')->comment('Type: materi, tugas, kuis');
                $table->unsignedBigInteger('id_konten')->comment('Content ID');
                
                $table->text('alasan')->comment('Reason for exemption');
                $table->dateTime('berlaku_hingga')->nullable()->comment('Exemption expiry date');
                
                $table->timestamps();
                $table->softDeletes();
                
                // Indexes
                $table->index(['tipe_konten', 'id_konten'], 'idx_exemption_content');
                $table->index('id_siswa', 'idx_exemption_siswa');
                
                // Unique constraint: one exemption per student per content
                $table->unique(['id_siswa', 'tipe_konten', 'id_konten'], 'unique_student_content_exemption');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $isSqlite = DB::getDriverName() === 'sqlite';

        // Drop indexes if they exist
        Schema::table('absensi', function (Blueprint $table) use ($isSqlite) {
            $indexes = $isSqlite
                ? DB::select("SELECT name FROM sqlite_master WHERE type='index' AND tbl_name='absensi' AND name='idx_absensi_content'")
                : DB::select("SHOW INDEX FROM absensi WHERE Key_name = 'idx_absensi_content'");
            if (!empty($indexes)) {
                $table->dropIndex('idx_absensi_content');
            }

            $indexes = $isSqlite
                ? DB::select("SELECT name FROM sqlite_master WHERE type='index' AND tbl_name='absensi' AND name='idx_absensi_batas'")
                : DB::select("SHOW INDEX FROM absensi WHERE Key_name = 'idx_absensi_batas'");
            if (!empty($indexes)) {
                $table->dropIndex('idx_absensi_batas');
            }
            
            if (Schema::hasColumn('absensi', 'tipe_konten')) {
                $table->dropColumn('tipe_konten');
            }
            if (Schema::hasColumn('absensi', 'id_konten')) {
                $table->dropColumn('id_konten');
            }
            if (Schema::hasColumn('absensi', 'batas_waktu_absen')) {
                $table->dropColumn('batas_waktu_absen');
            }
            if (Schema::hasColumn('absensi', 'status_keterlambatan')) {
                $table->dropColumn('status_keterlambatan');
            }
        });

        Schema::dropIfExists('content_exemptions');
    }
};
