<?php

namespace Database\Seeders;

use App\Models\Tingkatan;
use Illuminate\Database\Seeder;

class TingkatanSeeder extends Seeder
{
    public function run(): void
    {
        $tingkatans = [
            [
                'nama_tingkatan' => 'X',
                'keterangan'     => 'Kelas 10',
            ],
            [
                'nama_tingkatan' => 'XI',
                'keterangan'     => 'Kelas 11',
            ],
            [
                'nama_tingkatan' => 'XII',
                'keterangan'     => 'Kelas 12',
            ],
        ];

        foreach ($tingkatans as $tingkatan) {
            Tingkatan::firstOrCreate(
                ['nama_tingkatan' => $tingkatan['nama_tingkatan']],
                ['keterangan'     => $tingkatan['keterangan']]
            );
        }

        $this->command->info('TingkatanSeeder: ' . count($tingkatans) . ' data berhasil di-seed.');
    }
}