<?php

namespace Database\Seeders;

use App\Models\JadwalBelajar;
use App\Models\Pertemuan;
use Illuminate\Database\Seeder;

class PertemuanSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan JadwalBelajarSeeder sudah dijalankan
        $jadwalBelajars = JadwalBelajar::all();

        if ($jadwalBelajars->isEmpty()) {
            $this->command->error('JadwalBelajarSeeder belum dijalankan atau tidak ada data jadwal belajar.');
            return;
        }

        $totalSeeded = 0;

        foreach ($jadwalBelajars as $jadwal) {
            for ($i = 1; $i <= 16; $i++) {
                Pertemuan::firstOrCreate(
                    [
                        'id_jadwal'       => $jadwal->id,
                        'nomor_pertemuan' => $i,
                    ],
                    [
                        'tanggal' => null,
                        'status'  => 'dijadwalkan',
                    ]
                );

                $totalSeeded++;
            }
        }

        $this->command->info("PertemuanSeeder: {$totalSeeded} data berhasil di-seed.");
    }
}