<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FullSampleDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // ── Truncate semua tabel ──────────────────────────────────────
        $tables = [
            'activity_log','penilaian','pengumpulan_tugas','absensi',
            'tugas','materi','pertemuan','jadwal_belajar','jam_belajar',
            'guru_mapel','siswa','kelas','guru','mapel',
            'semester','tahun_ajaran','tingkatan','jurusan','bagian','users',
        ];
        foreach ($tables as $t) {
            DB::table($t)->truncate();
        }

        $now = Carbon::now();

        // ── 1. USERS ─────────────────────────────────────────────────
        DB::table('users')->insert([
            ['id'=>1,'name'=>'Super Admin','email'=>'admin@lms.test','password'=>Hash::make('password'),'role'=>'super_admin','email_verified_at'=>$now,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'name'=>'Budi Santoso','email'=>'guru1@lms.test','password'=>Hash::make('password'),'role'=>'guru','email_verified_at'=>$now,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>3,'name'=>'Siti Rahayu','email'=>'guru2@lms.test','password'=>Hash::make('password'),'role'=>'guru','email_verified_at'=>$now,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>4,'name'=>'Ahmad Fauzi','email'=>'siswa1@lms.test','password'=>Hash::make('password'),'role'=>'siswa','email_verified_at'=>$now,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>5,'name'=>'Dewi Lestari','email'=>'siswa2@lms.test','password'=>Hash::make('password'),'role'=>'siswa','email_verified_at'=>$now,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>6,'name'=>'Rizky Pratama','email'=>'siswa3@lms.test','password'=>Hash::make('password'),'role'=>'siswa','email_verified_at'=>$now,'created_at'=>$now,'updated_at'=>$now],
        ]);

        // ── 2. MASTER DATA ───────────────────────────────────────────
        DB::table('bagian')->insert([
            ['id'=>1,'nama_bagian'=>'A','deskripsi'=>'Bagian A','created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'nama_bagian'=>'B','deskripsi'=>'Bagian B','created_at'=>$now,'updated_at'=>$now],
        ]);

        DB::table('jurusan')->insert([
            ['id'=>1,'nama_jurusan'=>'Teknik Komputer dan Jaringan','keterangan'=>'TKJ','created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'nama_jurusan'=>'Rekayasa Perangkat Lunak','keterangan'=>'RPL','created_at'=>$now,'updated_at'=>$now],
        ]);

        DB::table('tingkatan')->insert([
            ['id'=>1,'nama_tingkatan'=>'X','keterangan'=>'Kelas 10','created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'nama_tingkatan'=>'XI','keterangan'=>'Kelas 11','created_at'=>$now,'updated_at'=>$now],
            ['id'=>3,'nama_tingkatan'=>'XII','keterangan'=>'Kelas 12','created_at'=>$now,'updated_at'=>$now],
        ]);

        DB::table('tahun_ajaran')->insert([
            ['id'=>1,'nama_tahun'=>'2024/2025','is_aktif'=>0,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'nama_tahun'=>'2025/2026','is_aktif'=>1,'created_at'=>$now,'updated_at'=>$now],
        ]);

        DB::table('semester')->insert([
            ['id'=>1,'nama_semester'=>'Ganjil 2025/2026','id_tahun_ajaran'=>2,'is_aktif'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'nama_semester'=>'Genap 2025/2026','id_tahun_ajaran'=>2,'is_aktif'=>0,'created_at'=>$now,'updated_at'=>$now],
        ]);

        DB::table('mapel')->insert([
            ['id'=>1,'kode_mapel'=>'MTK','nama_mapel'=>'Matematika','deskripsi'=>'Mata pelajaran matematika','created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'kode_mapel'=>'BIN','nama_mapel'=>'Bahasa Indonesia','deskripsi'=>'Mata pelajaran bahasa Indonesia','created_at'=>$now,'updated_at'=>$now],
            ['id'=>3,'kode_mapel'=>'PKK','nama_mapel'=>'Produk Kreatif dan Kewirausahaan','deskripsi'=>'PKK','created_at'=>$now,'updated_at'=>$now],
        ]);

        // ── 3. GURU ──────────────────────────────────────────────────
        DB::table('guru')->insert([
            ['id'=>1,'id_user'=>2,'nama_lengkap'=>'Budi Santoso','email'=>'guru1@lms.test','status_pengajar'=>'walikelas','created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'id_user'=>3,'nama_lengkap'=>'Siti Rahayu','email'=>'guru2@lms.test','status_pengajar'=>'pengajar','created_at'=>$now,'updated_at'=>$now],
        ]);

        // ── 4. KELAS (butuh id_wali_kelas → guru sudah ada) ──────────
        DB::table('kelas')->insert([
            ['id'=>1,'id_tingkatan'=>1,'id_jurusan'=>1,'id_bagian'=>1,'id_tahun_ajaran'=>2,'id_wali_kelas'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'id_tingkatan'=>1,'id_jurusan'=>2,'id_bagian'=>1,'id_tahun_ajaran'=>2,'id_wali_kelas'=>2,'created_at'=>$now,'updated_at'=>$now],
        ]);

        // ── 5. SISWA ─────────────────────────────────────────────────
        DB::table('siswa')->insert([
            ['id'=>1,'id_user'=>4,'nama_lengkap'=>'Ahmad Fauzi','email'=>'siswa1@lms.test','tanggal_lahir'=>'2008-03-15','agama'=>'Islam','id_kelas'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'id_user'=>5,'nama_lengkap'=>'Dewi Lestari','email'=>'siswa2@lms.test','tanggal_lahir'=>'2008-07-22','agama'=>'Islam','id_kelas'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>3,'id_user'=>6,'nama_lengkap'=>'Rizky Pratama','email'=>'siswa3@lms.test','tanggal_lahir'=>'2008-11-05','agama'=>'Islam','id_kelas'=>2,'created_at'=>$now,'updated_at'=>$now],
        ]);

        // ── 6. GURU MAPEL ────────────────────────────────────────────
        DB::table('guru_mapel')->insert([
            ['id'=>1,'id_mapel'=>1,'id_guru'=>1,'id_kelas'=>1,'id_semester'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'id_mapel'=>2,'id_guru'=>2,'id_kelas'=>1,'id_semester'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>3,'id_mapel'=>3,'id_guru'=>1,'id_kelas'=>2,'id_semester'=>1,'created_at'=>$now,'updated_at'=>$now],
        ]);

        // ── 7. JAM BELAJAR ───────────────────────────────────────────
        DB::table('jam_belajar')->insert([
            ['id'=>1,'jam_mulai'=>'07:00:00','jam_selesai'=>'07:45:00','created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'jam_mulai'=>'07:45:00','jam_selesai'=>'08:30:00','created_at'=>$now,'updated_at'=>$now],
            ['id'=>3,'jam_mulai'=>'08:30:00','jam_selesai'=>'09:15:00','created_at'=>$now,'updated_at'=>$now],
            ['id'=>4,'jam_mulai'=>'09:30:00','jam_selesai'=>'10:15:00','created_at'=>$now,'updated_at'=>$now],
            ['id'=>5,'jam_mulai'=>'10:15:00','jam_selesai'=>'11:00:00','created_at'=>$now,'updated_at'=>$now],
        ]);

        // ── 8. JADWAL BELAJAR ────────────────────────────────────────
        DB::table('jadwal_belajar')->insert([
            ['id'=>1,'id_guru_mapel'=>1,'id_kelas'=>1,'id_jam'=>1,'hari'=>'Senin','id_mapel'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'id_guru_mapel'=>2,'id_kelas'=>1,'id_jam'=>2,'hari'=>'Selasa','id_mapel'=>2,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>3,'id_guru_mapel'=>3,'id_kelas'=>2,'id_jam'=>1,'hari'=>'Rabu','id_mapel'=>3,'created_at'=>$now,'updated_at'=>$now],
        ]);

        // ── 9. PERTEMUAN ─────────────────────────────────────────────
        DB::table('pertemuan')->insert([
            ['id'=>1,'id_jadwal'=>1,'id_guru'=>1,'nomor_pertemuan'=>1,'tanggal'=>$now->copy()->subDays(14)->toDateString(),'status'=>'selesai','created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'id_jadwal'=>1,'id_guru'=>1,'nomor_pertemuan'=>2,'tanggal'=>$now->copy()->subDays(7)->toDateString(),'status'=>'selesai','created_at'=>$now,'updated_at'=>$now],
            ['id'=>3,'id_jadwal'=>1,'id_guru'=>1,'nomor_pertemuan'=>3,'tanggal'=>$now->toDateString(),'status'=>'dijadwalkan','created_at'=>$now,'updated_at'=>$now],
            ['id'=>4,'id_jadwal'=>2,'id_guru'=>2,'nomor_pertemuan'=>1,'tanggal'=>$now->copy()->subDays(10)->toDateString(),'status'=>'selesai','created_at'=>$now,'updated_at'=>$now],
        ]);

        // ── 10. MATERI ───────────────────────────────────────────────
        DB::table('materi')->insert([
            ['id'=>1,'id_pertemuan'=>1,'id_mapel'=>1,'id_guru_mapel'=>1,'judul'=>'Pengantar Aljabar Linear','deskripsi'=>'Materi dasar aljabar linear untuk kelas X TKJ.','tipe_materi'=>'dokumen','file_url'=>null,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'id_pertemuan'=>1,'id_mapel'=>1,'id_guru_mapel'=>1,'judul'=>'Video: Operasi Matriks','deskripsi'=>'Tonton video ini sebelum pertemuan berikutnya.','tipe_materi'=>'video','file_url'=>null,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>3,'id_pertemuan'=>2,'id_mapel'=>1,'id_guru_mapel'=>1,'judul'=>'Modul 2: Determinan dan Invers','deskripsi'=>'Lanjutan materi matriks.','tipe_materi'=>'dokumen','file_url'=>null,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>4,'id_pertemuan'=>4,'id_mapel'=>2,'id_guru_mapel'=>2,'judul'=>'Teks Eksposisi','deskripsi'=>'Pengertian dan struktur teks eksposisi.','tipe_materi'=>'dokumen','file_url'=>null,'created_at'=>$now,'updated_at'=>$now],
        ]);

        // ── 11. TUGAS ────────────────────────────────────────────────
        DB::table('tugas')->insert([
            ['id'=>1,'id_pertemuan'=>1,'id_guru'=>1,'id_mapel'=>1,'id_guru_mapel'=>1,'judul'=>'Tugas 1: Operasi Matriks','deskripsi'=>'Kerjakan soal-soal operasi matriks berikut.','tipe_tugas'=>'individu','batas_waktu'=>$now->copy()->subDays(7),'nilai_maksimal'=>100,'status'=>'published','allow_late'=>false,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'id_pertemuan'=>2,'id_guru'=>1,'id_mapel'=>1,'id_guru_mapel'=>1,'judul'=>'Tugas 2: Determinan Matriks','deskripsi'=>'Hitung determinan dari matriks yang diberikan.','tipe_tugas'=>'individu','batas_waktu'=>$now->copy()->addDays(3),'nilai_maksimal'=>100,'status'=>'published','allow_late'=>true,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>3,'id_pertemuan'=>4,'id_guru'=>2,'id_mapel'=>2,'id_guru_mapel'=>2,'judul'=>'Tugas Teks Eksposisi','deskripsi'=>'Buatlah teks eksposisi bertema lingkungan hidup.','tipe_tugas'=>'individu','batas_waktu'=>$now->copy()->addDays(5),'nilai_maksimal'=>100,'status'=>'published','allow_late'=>false,'created_at'=>$now,'updated_at'=>$now],
        ]);

        // ── 12. ABSENSI ──────────────────────────────────────────────
        DB::table('absensi')->insert([
            ['id'=>1,'id_pertemuan'=>1,'id_siswa'=>1,'status'=>'hadir','keterangan'=>null,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'id_pertemuan'=>1,'id_siswa'=>2,'status'=>'hadir','keterangan'=>null,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>3,'id_pertemuan'=>2,'id_siswa'=>1,'status'=>'hadir','keterangan'=>null,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>4,'id_pertemuan'=>2,'id_siswa'=>2,'status'=>'izin','keterangan'=>'Sakit demam','created_at'=>$now,'updated_at'=>$now],
            ['id'=>5,'id_pertemuan'=>4,'id_siswa'=>1,'status'=>'hadir','keterangan'=>null,'created_at'=>$now,'updated_at'=>$now],
        ]);

        // ── 13. PENGUMPULAN TUGAS ────────────────────────────────────
        DB::table('pengumpulan_tugas')->insert([
            ['id'=>1,'id_tugas'=>1,'id_siswa'=>1,'file_url'=>null,'catatan'=>'Ini jawaban tugas saya, mohon dikoreksi.','created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'id_tugas'=>1,'id_siswa'=>2,'file_url'=>null,'catatan'=>'Sudah saya kerjakan semua soalnya.','created_at'=>$now,'updated_at'=>$now],
            ['id'=>3,'id_tugas'=>3,'id_siswa'=>1,'file_url'=>null,'catatan'=>'Teks eksposisi tentang daur ulang sampah.','created_at'=>$now,'updated_at'=>$now],
        ]);

        // ── 14. PENILAIAN ────────────────────────────────────────────
        DB::table('penilaian')->insert([
            ['id'=>1,'id_pengumpulan_tugas'=>1,'id_guru'=>1,'nilai'=>88,'nilai_maksimal_snapshot'=>100,'catatan_guru'=>'Bagus, tapi perhatikan penulisan langkah-langkahnya.','created_at'=>$now,'updated_at'=>$now],
            ['id'=>2,'id_pengumpulan_tugas'=>2,'id_guru'=>1,'nilai'=>75,'nilai_maksimal_snapshot'=>100,'catatan_guru'=>'Cukup baik, masih ada beberapa kesalahan perhitungan.','created_at'=>$now,'updated_at'=>$now],
            ['id'=>3,'id_pengumpulan_tugas'=>3,'id_guru'=>2,'nilai'=>92,'nilai_maksimal_snapshot'=>100,'catatan_guru'=>'Teks eksposisi sangat baik dan terstruktur.','created_at'=>$now,'updated_at'=>$now],
        ]);

        // ── 15. ACTIVITY LOG ─────────────────────────────────────────
        DB::table('activity_log')->insert([
            ['id_user'=>1,'aksi'=>'LOGIN','modul'=>'Auth','deskripsi'=>'Super Admin login ke sistem.','ip_address'=>'127.0.0.1','created_at'=>$now->copy()->subHours(3)],
            ['id_user'=>2,'aksi'=>'CREATE','modul'=>'Materi','deskripsi'=>'Menambahkan materi Pengantar Aljabar Linear.','ip_address'=>'127.0.0.1','created_at'=>$now->copy()->subHours(2)],
            ['id_user'=>2,'aksi'=>'CREATE','modul'=>'Tugas','deskripsi'=>'Membuat tugas Operasi Matriks.','ip_address'=>'127.0.0.1','created_at'=>$now->copy()->subHours(1)],
            ['id_user'=>1,'aksi'=>'CREATE','modul'=>'Kelas','deskripsi'=>'Menambahkan kelas X TKJ A.','ip_address'=>'127.0.0.1','created_at'=>$now->copy()->subMinutes(30)],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('✅ Data sampel berhasil dibuat!');
        $this->command->info('');
        $this->command->info('Akun login:');
        $this->command->info('  Super Admin : admin@lms.test     / password');
        $this->command->info('  Guru 1      : guru1@lms.test     / password');
        $this->command->info('  Guru 2      : guru2@lms.test     / password');
        $this->command->info('  Siswa 1     : siswa1@lms.test    / password');
        $this->command->info('  Siswa 2     : siswa2@lms.test    / password');
        $this->command->info('  Siswa 3     : siswa3@lms.test    / password');
    }
}
