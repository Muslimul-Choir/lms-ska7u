<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelas = [
            ['id_tingkatan' => 1, 'id_jurusan' => 1, 'id_bagian' => 1, 'id_tahun_ajaran' => 1, 'id_wali_kelas' => 1],
            ['id_tingkatan' => 1, 'id_jurusan' => 2, 'id_bagian' => 1, 'id_tahun_ajaran' => 1, 'id_wali_kelas' => 2],
            ['id_tingkatan' => 2, 'id_jurusan' => 1, 'id_bagian' => 1, 'id_tahun_ajaran' => 1, 'id_wali_kelas' => 1],
        ];

        foreach ($kelas as $k) {
            Kelas::create($k);
        }

        $this->command->info(count($kelas) . ' data kelas berhasil di-seed.');
    }
}