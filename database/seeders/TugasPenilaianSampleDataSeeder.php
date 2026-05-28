<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Penilaian;
use App\Models\PengumpulanTugas;
use App\Models\Siswa;
use App\Models\Tugas;
use Illuminate\Database\Seeder;

class TugasPenilaianSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('📝 Membuat data sampel pengumpulan tugas dan penilaian...');

        // Get first tugas
        $tugas = Tugas::first();
        $guru = Guru::first();

        if (!$tugas) {
            $this->command->warn('⚠️ Tidak ada data tugas. Jalankan LmsSampleDataSeeder terlebih dahulu.');
            return;
        }

        if (!$guru) {
            $this->command->warn('⚠️ Tidak ada data guru. Jalankan LmsSampleDataSeeder terlebih dahulu.');
            return;
        }

        // Get siswa from the same class as the tugas
        $siswaList = Siswa::where('id_kelas', $tugas->GuruMapel->id_kelas ?? null)
            ->take(8)
            ->get();

        if ($siswaList->count() === 0) {
            $this->command->warn('⚠️ Tidak ada siswa di kelas yang sama dengan tugas.');
            return;
        }

        $catatanSamples = [
            'Pekerjaan bagus! Jawaban lengkap dan terstruktur dengan baik.',
            'Sudah cukup baik, namun perlu lebih detail dalam penjelasan.',
            'Kerja keras terlihat, teruskan!',
            'Jawaban benar, tapi bisa lebih rapi dalam penyajian.',
            'Sangat baik! Pemahaman materi sangat mendalam.',
            'Cukup, namun ada beberapa konsep yang perlu diperbaiki.',
            'Bagus sekali! Kreatif dalam menjawab.',
            'Perlu lebih teliti dalam mengerjakan.',
        ];

        $submissionCount = 0;
        $gradedCount = 0;

        foreach ($siswaList as $index => $siswa) {
            // Scenario 1: Siswa sudah mengumpulkan dan sudah dinilai (5 siswa pertama)
            if ($index < 5) {
                $submission = PengumpulanTugas::create([
                    'id_tugas' => $tugas->id,
                    'id_siswa' => $siswa->id,
                    'file_url' => null, // Tipe tugas tanpa file
                    'catatan' => "Jawaban tugas dari {$siswa->nama_lengkap}. Saya sudah mengerjakan dengan sebaik-baiknya sesuai dengan instruksi yang diberikan.",
                ]);

                $submissionCount++;

                // Buat penilaian dengan nilai bervariasi
                $nilai = [85, 90, 75, 88, 92][$index];
                
                Penilaian::create([
                    'id_pengumpulan_tugas' => $submission->id,
                    'id_guru' => $guru->id,
                    'nilai' => $nilai,
                    'nilai_maksimal_snapshot' => $tugas->nilai_maksimal ?? 100,
                    'catatan_guru' => $catatanSamples[$index],
                ]);

                $gradedCount++;
            }
            // Scenario 2: Siswa sudah mengumpulkan tapi belum dinilai (2 siswa berikutnya)
            elseif ($index < 7) {
                PengumpulanTugas::create([
                    'id_tugas' => $tugas->id,
                    'id_siswa' => $siswa->id,
                    'file_url' => null,
                    'catatan' => "Jawaban tugas dari {$siswa->nama_lengkap}. Mohon diperiksa, terima kasih.",
                ]);

                $submissionCount++;
            }
            // Scenario 3: Siswa belum mengumpulkan (1 siswa terakhir)
            // Tidak perlu create apa-apa
        }

        $this->command->info("✅ {$submissionCount} pengumpulan tugas dibuat");
        $this->command->info("✅ {$gradedCount} penilaian dibuat");
        $this->command->info('');
        $this->command->info('🎉 Seeder TugasPenilaianSampleDataSeeder selesai!');
        $this->command->info('');
        $this->command->info('📋 Ringkasan:');
        $this->command->info("   - {$submissionCount} siswa sudah mengumpulkan tugas");
        $this->command->info("   - {$gradedCount} tugas sudah dinilai");
        $this->command->info("   - " . ($submissionCount - $gradedCount) . " tugas menunggu dinilai");
        $this->command->info("   - " . ($siswaList->count() - $submissionCount) . " siswa belum mengumpulkan");
    }
}
