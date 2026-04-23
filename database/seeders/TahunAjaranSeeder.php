<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAjarans = [
            ['nama_tahun' => '2022/2023', 'is_aktif' => false],
            ['nama_tahun' => '2023/2024', 'is_aktif' => false],
            ['nama_tahun' => '2024/2025', 'is_aktif' => false],
            ['nama_tahun' => '2025/2026', 'is_aktif' => false],
            ['nama_tahun' => '2026/2027', 'is_aktif' => true],
        ];

        foreach ($tahunAjarans as $tahun) {
            TahunAjaran::firstOrCreate(
                ['nama_tahun' => $tahun['nama_tahun']],
                ['is_aktif' => $tahun['is_aktif']]
            );
        }

        $this->command->info('TahunAjaranSeeder: ' . count($tahunAjarans) . ' data berhasil di-seed.');
    }
}