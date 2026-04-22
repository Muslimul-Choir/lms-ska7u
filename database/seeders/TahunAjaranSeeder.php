<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAjarans = [
            ['nama_tahun' => '2022/2023'],
            ['nama_tahun' => '2023/2024'],
            ['nama_tahun' => '2024/2025'],
            ['nama_tahun' => '2025/2026'],
            ['nama_tahun' => '2026/2027'],
        ];

        foreach ($tahunAjarans as $tahun) {
            TahunAjaran::firstOrCreate(
                ['nama_tahun' => $tahun['nama_tahun']]
            );
        }

        $this->command->info('TahunAjaranSeeder: ' . count($tahunAjarans) . ' data berhasil di-seed.');
    }
}