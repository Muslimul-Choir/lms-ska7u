<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pertemuan;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;

class LmsSampleDataSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Pastikan ada jadwal belajar ID 1
        $jadwal = \App\Models\JadwalBelajar::find(1);
        if (!$jadwal) {
            DB::table('jadwal_belajar')->insert([
                'id' => 1,
                'id_guru_mapel' => 1,
                'hari' => 'Senin',
                'id_jam' => 1,
                'id_kelas' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $jadwal = \App\Models\JadwalBelajar::find(1);
        }

        // 1. Ambil 1 Pertemuan secara random, jika tidak ada, buat baru
        $pertemuan = Pertemuan::first();
        if (!$pertemuan) {
            $pertemuanId = DB::table('pertemuan')->insertGetId([
                'id_jadwal' => 1,
                'nomor_pertemuan' => 1,
                'tanggal' => now()->format('Y-m-d'),
                'status' => 'dijadwalkan',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $pertemuan = Pertemuan::find($pertemuanId);
        }

        // 2. Ambil 1 Guru dan 1 Siswa, buat jika kosong
        // 2. Ambil 1 Guru dan 1 Siswa, buat jika kosong
        $guru = Guru::first();
        if (!$guru) {
            $userG = User::where('email', 'guru_dummy@contoh.com')->first();
            if (!$userG) {
                $userGId = DB::table('users')->insertGetId(['name' => 'Guru Dummy', 'email' => 'guru_dummy@contoh.com', 'password' => bcrypt('password'), 'role' => 'guru', 'created_at' => now(), 'updated_at' => now()]);
            } else {
                $userGId = $userG->id;
            }
            $guruId = DB::table('guru')->insertGetId(['id_user' => $userGId, 'nama_lengkap' => 'Guru Dummy', 'email' => 'guru_dummy@contoh.com', 'status_pengajar' => 'pengajar', 'created_at' => now(), 'updated_at' => now()]);
            $guru = Guru::find($guruId);
        }
        
        $siswa = Siswa::first();
        if (!$siswa) {
            $userS = User::where('email', 'siswa_dummy@contoh.com')->first();
            if (!$userS) {
                $userSId = DB::table('users')->insertGetId(['name' => 'Siswa Dummy', 'email' => 'siswa_dummy@contoh.com', 'password' => bcrypt('password'), 'role' => 'siswa', 'created_at' => now(), 'updated_at' => now()]);
            } else {
                $userSId = $userS->id;
            }
            $siswaId = DB::table('siswa')->insertGetId(['id_user' => $userSId, 'nama_lengkap' => 'Siswa Dummy', 'email' => 'siswa_dummy@contoh.com', 'agama' => 'Islam', 'id_kelas' => 1, 'created_at' => now(), 'updated_at' => now()]);
            $siswa = Siswa::find($siswaId);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Ambil 1 Guru dan 1 Siswa secara random
        $guru = Guru::first();
        $siswa = Siswa::first();
        
        $userAdmin = User::where('role', 'admin')->first() ?? User::first();

        // Kosongkan data sebelumnya agar tidak dobel
        DB::table('activity_log')->delete();
        DB::table('penilaian')->delete();
        DB::table('pengumpulan_tugas')->delete();
        DB::table('tugas')->delete();
        DB::table('materi')->delete();

        // --- 1. Data Materi ---
        $materis = [
            [
                'id_pertemuan' => $pertemuan->id,
                'judul' => 'Pengenalan Materi Dasar',
                'deskripsi' => 'Silakan tonton video pengantar berikut untuk memahami konsep dasarnya.',
                'tipe_materi' => 'video',
                'file_url' => null, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pertemuan' => $pertemuan->id,
                'judul' => 'Modul 1: Teori dan Praktik',
                'deskripsi' => 'Baca modul PDF ini sebelum mengerjakan tugas yang diberikan.',
                'tipe_materi' => 'dokumen',
                'file_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pertemuan' => $pertemuan->id,
                'judul' => 'Artikel Tambahan: Sejarah Singkat',
                'deskripsi' => 'Sejarah dimulai pada awal mula penemuan. Pada abad ke-19, banyak sekali perubahan yang terjadi dalam bidang sains dan teknologi. Pembelajaran ini akan memandu Anda memahami konteks historis dari pelajaran kita kali ini.',
                'tipe_materi' => 'lainnya',
                'file_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        DB::table('materi')->insert($materis);

        // --- 2. Data Tugas ---
        if ($guru) {
            $tugasId = DB::table('tugas')->insertGetId([
                'id_pertemuan' => $pertemuan->id,
                'id_guru' => $guru->id,
                'judul' => 'Tugas 1: Menganalisis Kasus Lapangan',
                'deskripsi' => 'Buatlah makalah analisis berdasarkan video dan modul yang telah diberikan. Upload dalam format PDF.',
                'file_url' => null,
                'tipe_tugas' => 'individu',
                'batas_waktu' => Carbon::now()->addDays(3),
                'nilai_maksimal' => 100,
                'status' => 'published',
                'allow_late' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('tugas')->insert([
                'id_pertemuan' => $pertemuan->id,
                'id_guru' => $guru->id,
                'judul' => 'Tugas Kelompok: Presentasi',
                'deskripsi' => 'Buat slide presentasi kelompok. (Draft belum dipublish)',
                'file_url' => null,
                'tipe_tugas' => 'kelompok',
                'batas_waktu' => Carbon::now()->addDays(7),
                'nilai_maksimal' => 100,
                'status' => 'draft',
                'allow_late' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // --- 3. Data Pengumpulan Tugas ---
            if ($siswa) {
                $pengumpulanId = DB::table('pengumpulan_tugas')->insertGetId([
                    'id_tugas' => $tugasId,
                    'id_siswa' => $siswa->id,
                    'file_url' => null,
                    'catatan' => 'Maaf pak/bu, ini tugas saya. Mohon koreksinya.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // --- 4. Data Penilaian ---
                DB::table('penilaian')->insert([
                    'id_pengumpulan_tugas' => $pengumpulanId,
                    'id_guru' => $guru->id,
                    'nilai' => 88,
                    'nilai_maksimal_snapshot' => 100,
                    'catatan_guru' => 'Analisisnya sudah bagus, tapi perhatikan lagi tata letak paragrafnya.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // --- 5. Data Activity Log ---
        if ($userAdmin) {
            $logs = [
                [
                    'id_user' => $userAdmin->id,
                    'aksi' => 'LOGIN',
                    'modul' => 'Auth',
                    'deskripsi' => 'User login ke sistem aplikasi LMS.',
                    'ip_address' => '127.0.0.1',
                    'created_at' => now()->subHours(5),
                ],
                [
                    'id_user' => $userAdmin->id,
                    'aksi' => 'CREATE',
                    'modul' => 'Materi',
                    'deskripsi' => 'Menambahkan materi pembelajaran baru.',
                    'ip_address' => '127.0.0.1',
                    'created_at' => now()->subHours(4),
                ],
                [
                    'id_user' => $userAdmin->id,
                    'aksi' => 'UPDATE',
                    'modul' => 'Pengaturan',
                    'deskripsi' => 'Mengubah konfigurasi sistem penilaian.',
                    'ip_address' => '127.0.0.1',
                    'created_at' => now()->subMinutes(30),
                ]
            ];
            DB::table('activity_log')->insert($logs);
        }

        echo "Sample data untuk LMS berhasil ditambahkan!\n";
    }
}
