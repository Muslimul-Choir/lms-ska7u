<?php

namespace Database\Seeders;

use App\Models\Mapel;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run(): void
    {
        $mapels = [
            [
                'kode_mapel' => 'MTK',
                'nama_mapel'  => 'Matematika',
                'deskripsi'   => 'Mempelajari konsep bilangan, aljabar, geometri, dan statistika.',
            ],
            [
                'kode_mapel' => 'BIN',
                'nama_mapel'  => 'Bahasa Indonesia',
                'deskripsi'   => 'Mempelajari tata bahasa, menulis, membaca, dan sastra Indonesia.',
            ],
            [
                'kode_mapel' => 'BING',
                'nama_mapel'  => 'Bahasa Inggris',
                'deskripsi'   => 'Mempelajari grammar, speaking, reading, dan writing dalam bahasa Inggris.',
            ],
            [
                'kode_mapel' => 'IPA',
                'nama_mapel'  => 'Ilmu Pengetahuan Alam',
                'deskripsi'   => 'Mempelajari fisika, kimia, dan biologi dasar.',
            ],
            [
                'kode_mapel' => 'IPS',
                'nama_mapel'  => 'Ilmu Pengetahuan Sosial',
                'deskripsi'   => 'Mempelajari ekonomi, sejarah, geografi, dan sosiologi.',
            ],
            [
                'kode_mapel' => 'PABP',
                'nama_mapel'  => 'Pendidikan Agama dan Budi Pekerti',
                'deskripsi'   => 'Mempelajari nilai agama dan pembentukan karakter siswa.',
            ],
            [
                'kode_mapel' => 'PKN',
                'nama_mapel'  => 'Pendidikan Pancasila dan Kewarganegaraan',
                'deskripsi'   => 'Mempelajari nilai Pancasila, hukum, dan kewarganegaraan.',
            ],
            [
                'kode_mapel' => 'PJOK',
                'nama_mapel'  => 'Pendidikan Jasmani, Olahraga, dan Kesehatan',
                'deskripsi'   => 'Meningkatkan kebugaran jasmani dan kesehatan siswa.',
            ],
        ];

        foreach ($mapels as $mapel) {
            Mapel::firstOrCreate(
                ['kode_mapel' => $mapel['kode_mapel']],
                [
                    'nama_mapel' => $mapel['nama_mapel'],
                    'deskripsi'  => $mapel['deskripsi'],
                ]
            );
        }

        $this->command->info('MapelSeeder: ' . count($mapels) . ' data berhasil di-seed.');
    }
}