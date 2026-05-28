<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\GuruMapel;
use App\Models\HasilKuis;
use App\Models\Kuis;
use App\Models\Pertemuan;
use App\Models\Siswa;
use App\Models\SoalKuis;
use Illuminate\Database\Seeder;

class KuisSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first guru and guru_mapel
        $guru = Guru::first();
        $guruMapel = GuruMapel::first();
        $pertemuan = Pertemuan::first();

        if (!$guru || !$guruMapel || !$pertemuan) {
            $this->command->warn('⚠️ Tidak ada data guru, guru_mapel, atau pertemuan. Jalankan LmsSampleDataSeeder terlebih dahulu.');
            return;
        }

        $this->command->info('🎯 Membuat data sampel kuis...');

        // Kuis 1: Matematika - Published
        $kuis1 = Kuis::create([
            'id_pertemuan' => $pertemuan->id,
            'id_guru_mapel' => $guruMapel->id,
            'id_guru' => $guru->id,
            'judul' => 'Kuis Matematika: Aljabar Dasar',
            'deskripsi' => 'Kuis ini menguji pemahaman siswa tentang konsep aljabar dasar, termasuk operasi bilangan bulat, persamaan linear, dan pemfaktoran.',
            'durasi' => 30,
            'nilai_maksimal' => 100.00,
            'batas_mulai' => now()->subDays(2),
            'batas_selesai' => now()->addDays(5),
            'status' => 'published',
        ]);

        // Soal untuk Kuis 1
        $soalKuis1 = [
            [
                'nomor_soal' => 1,
                'pertanyaan' => 'Berapakah hasil dari 15 + 8 × 2?',
                'pilihan_a' => '46',
                'pilihan_b' => '31',
                'pilihan_c' => '38',
                'pilihan_d' => '23',
                'kunci_jawaban' => 'B',
            ],
            [
                'nomor_soal' => 2,
                'pertanyaan' => 'Jika x + 5 = 12, berapakah nilai x?',
                'pilihan_a' => '5',
                'pilihan_b' => '6',
                'pilihan_c' => '7',
                'pilihan_d' => '8',
                'kunci_jawaban' => 'C',
            ],
            [
                'nomor_soal' => 3,
                'pertanyaan' => 'Faktorkan: x² + 5x + 6',
                'pilihan_a' => '(x + 2)(x + 3)',
                'pilihan_b' => '(x + 1)(x + 6)',
                'pilihan_c' => '(x - 2)(x - 3)',
                'pilihan_d' => '(x + 4)(x + 2)',
                'kunci_jawaban' => 'A',
            ],
            [
                'nomor_soal' => 4,
                'pertanyaan' => 'Berapakah hasil dari (-3) × (-4)?',
                'pilihan_a' => '-12',
                'pilihan_b' => '12',
                'pilihan_c' => '-7',
                'pilihan_d' => '7',
                'kunci_jawaban' => 'B',
            ],
            [
                'nomor_soal' => 5,
                'pertanyaan' => 'Jika 2x - 3 = 7, berapakah nilai x?',
                'pilihan_a' => '3',
                'pilihan_b' => '4',
                'pilihan_c' => '5',
                'pilihan_d' => '6',
                'kunci_jawaban' => 'C',
            ],
        ];

        foreach ($soalKuis1 as $soal) {
            SoalKuis::create(array_merge($soal, ['id_kuis' => $kuis1->id]));
        }

        $this->command->info("✅ Kuis 1 dibuat: {$kuis1->judul} dengan 5 soal");

        // Kuis 2: Bahasa Indonesia - Published
        $kuis2 = Kuis::create([
            'id_pertemuan' => $pertemuan->id,
            'id_guru_mapel' => $guruMapel->id,
            'id_guru' => $guru->id,
            'judul' => 'Kuis Bahasa Indonesia: Tata Bahasa',
            'deskripsi' => 'Kuis tentang tata bahasa Indonesia, meliputi subjek, predikat, objek, dan kalimat efektif.',
            'durasi' => 25,
            'nilai_maksimal' => 100.00,
            'batas_mulai' => now()->subDays(1),
            'batas_selesai' => now()->addDays(7),
            'status' => 'published',
        ]);

        // Soal untuk Kuis 2
        $soalKuis2 = [
            [
                'nomor_soal' => 1,
                'pertanyaan' => 'Manakah yang merupakan kalimat efektif?',
                'pilihan_a' => 'Saya pergi ke pasar untuk membeli sayur-sayuran.',
                'pilihan_b' => 'Saya pergi ke pasar membeli sayur.',
                'pilihan_c' => 'Saya ke pasar untuk beli sayur-sayuran.',
                'pilihan_d' => 'Pergi ke pasar saya membeli sayur.',
                'kunci_jawaban' => 'B',
            ],
            [
                'nomor_soal' => 2,
                'pertanyaan' => 'Apa fungsi kata "yang" dalam kalimat "Buku yang saya baca sangat menarik"?',
                'pilihan_a' => 'Kata penghubung',
                'pilihan_b' => 'Kata ganti',
                'pilihan_c' => 'Kata sifat',
                'pilihan_d' => 'Kata keterangan',
                'kunci_jawaban' => 'A',
            ],
            [
                'nomor_soal' => 3,
                'pertanyaan' => 'Manakah penulisan kata baku yang benar?',
                'pilihan_a' => 'Aktifitas',
                'pilihan_b' => 'Aktivitas',
                'pilihan_c' => 'Aktipitas',
                'pilihan_d' => 'Aktiftas',
                'kunci_jawaban' => 'B',
            ],
        ];

        foreach ($soalKuis2 as $soal) {
            SoalKuis::create(array_merge($soal, ['id_kuis' => $kuis2->id]));
        }

        $this->command->info("✅ Kuis 2 dibuat: {$kuis2->judul} dengan 3 soal");

        // Kuis 3: Draft (belum dipublikasikan)
        $kuis3 = Kuis::create([
            'id_pertemuan' => $pertemuan->id,
            'id_guru_mapel' => $guruMapel->id,
            'id_guru' => $guru->id,
            'judul' => 'Kuis IPA: Sistem Tata Surya',
            'deskripsi' => 'Kuis tentang planet-planet dalam sistem tata surya dan karakteristiknya.',
            'durasi' => 20,
            'nilai_maksimal' => 100.00,
            'batas_mulai' => now()->addDays(3),
            'batas_selesai' => now()->addDays(10),
            'status' => 'draft',
        ]);

        // Soal untuk Kuis 3 (draft)
        $soalKuis3 = [
            [
                'nomor_soal' => 1,
                'pertanyaan' => 'Planet terbesar dalam sistem tata surya adalah?',
                'pilihan_a' => 'Saturnus',
                'pilihan_b' => 'Jupiter',
                'pilihan_c' => 'Uranus',
                'pilihan_d' => 'Neptunus',
                'kunci_jawaban' => 'B',
            ],
            [
                'nomor_soal' => 2,
                'pertanyaan' => 'Berapa jumlah planet dalam sistem tata surya?',
                'pilihan_a' => '7',
                'pilihan_b' => '8',
                'pilihan_c' => '9',
                'pilihan_d' => '10',
                'kunci_jawaban' => 'B',
            ],
        ];

        foreach ($soalKuis3 as $soal) {
            SoalKuis::create(array_merge($soal, ['id_kuis' => $kuis3->id]));
        }

        $this->command->info("✅ Kuis 3 dibuat: {$kuis3->judul} (Draft) dengan 2 soal");

        // Buat hasil kuis untuk beberapa siswa
        $siswaList = Siswa::take(5)->get();

        if ($siswaList->count() > 0) {
            $this->command->info('📊 Membuat hasil kuis untuk siswa...');

            foreach ($siswaList as $index => $siswa) {
                // Hasil untuk Kuis 1
                $jawaban1 = [
                    1 => ['A', 'B', 'C', 'B', 'A'][$index % 5], // Variasi jawaban
                    2 => ['C', 'C', 'B', 'C', 'D'][$index % 5],
                    3 => ['A', 'B', 'A', 'A', 'C'][$index % 5],
                    4 => ['B', 'B', 'A', 'B', 'B'][$index % 5],
                    5 => ['C', 'D', 'C', 'C', 'C'][$index % 5],
                ];

                // Hitung jumlah benar
                $benar1 = 0;
                $kunciJawaban1 = ['B', 'C', 'A', 'B', 'C'];
                foreach ($jawaban1 as $nomor => $jawab) {
                    if ($jawab === $kunciJawaban1[$nomor - 1]) {
                        $benar1++;
                    }
                }

                $nilai1 = ($benar1 / 5) * 100;

                HasilKuis::create([
                    'id_kuis' => $kuis1->id,
                    'id_siswa' => $siswa->id,
                    'jawaban' => $jawaban1,
                    'nilai' => $nilai1,
                    'jumlah_benar' => $benar1,
                    'waktu_mulai' => now()->subHours(2),
                    'waktu_selesai' => now()->subHours(1)->subMinutes(rand(5, 25)),
                ]);

                // Hasil untuk Kuis 2 (hanya 3 siswa pertama)
                if ($index < 3) {
                    $jawaban2 = [
                        1 => ['B', 'A', 'B'][$index],
                        2 => ['A', 'A', 'B'][$index],
                        3 => ['B', 'B', 'B'][$index],
                    ];

                    $benar2 = 0;
                    $kunciJawaban2 = ['B', 'A', 'B'];
                    foreach ($jawaban2 as $nomor => $jawab) {
                        if ($jawab === $kunciJawaban2[$nomor - 1]) {
                            $benar2++;
                        }
                    }

                    $nilai2 = ($benar2 / 3) * 100;

                    HasilKuis::create([
                        'id_kuis' => $kuis2->id,
                        'id_siswa' => $siswa->id,
                        'jawaban' => $jawaban2,
                        'nilai' => $nilai2,
                        'jumlah_benar' => $benar2,
                        'waktu_mulai' => now()->subHours(1),
                        'waktu_selesai' => now()->subMinutes(rand(10, 20)),
                    ]);
                }
            }

            $this->command->info("✅ Hasil kuis dibuat untuk {$siswaList->count()} siswa");
        } else {
            $this->command->warn('⚠️ Tidak ada data siswa. Hasil kuis tidak dibuat.');
        }

        $this->command->info('');
        $this->command->info('🎉 Seeder KuisSampleDataSeeder selesai!');
        $this->command->info('');
        $this->command->info('📋 Ringkasan:');
        $this->command->info("   - 3 Kuis dibuat (2 published, 1 draft)");
        $this->command->info("   - 10 Soal kuis dibuat");
        $this->command->info("   - " . HasilKuis::count() . " Hasil kuis dibuat");
    }
}
