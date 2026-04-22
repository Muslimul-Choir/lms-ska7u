<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    
    public function run(): void
    {
        $jurusans = [
            [
                'nama_jurusan' => 'Teknik Informatika',
                'keterangan'   => 'Mempelajari ilmu komputer, pemrograman, dan pengembangan perangkat lunak.',
            ],
            [
                'nama_jurusan' => 'Sistem Informasi',
                'keterangan'   => 'Mempelajari pengelolaan informasi berbasis teknologi untuk kebutuhan bisnis.',
            ],
            [
                'nama_jurusan' => 'Teknik Elektro',
                'keterangan'   => 'Mempelajari sistem kelistrikan, elektronika, dan otomasi.',
            ],
            [
                'nama_jurusan' => 'Teknik Mesin',
                'keterangan'   => 'Mempelajari perancangan, pembuatan, dan perawatan mesin.',
            ],
            [
                'nama_jurusan' => 'Manajemen',
                'keterangan'   => 'Mempelajari pengelolaan organisasi, sumber daya, dan strategi bisnis.',
            ],
            [
                'nama_jurusan' => 'Akuntansi',
                'keterangan'   => 'Mempelajari pencatatan, pelaporan, dan analisis keuangan.',
            ],
            [
                'nama_jurusan' => 'Ilmu Komunikasi',
                'keterangan'   => 'Mempelajari teori dan praktik komunikasi massa dan interpersonal.',
            ],
            [
                'nama_jurusan' => 'Hukum',
                'keterangan'   => 'Mempelajari peraturan perundang-undangan dan sistem hukum.',
            ],
        ];

        foreach ($jurusans as $jurusan) {
            Jurusan::firstOrCreate(
                ['nama_jurusan' => $jurusan['nama_jurusan']],
                ['keterangan'   => $jurusan['keterangan']]
            );
        }

        $this->command->info('JurusanSeeder: ' . count($jurusans) . ' data berhasil di-seed.');
    }
}