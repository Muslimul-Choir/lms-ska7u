<?php

namespace Database\Seeders;

use App\Models\JadwalBelajar;
use Illuminate\Database\Seeder;

class JadwalBelajarSeeder extends Seeder
{
    public function run(): void
    {
        JadwalBelajar::insert([
            // Kelas 1
            ['id_guru_mapel' => 1, 'id_jam' => 1, 'id_kelas' => 1, 'hari' => 'Senin'],
            ['id_guru_mapel' => 2, 'id_jam' => 2, 'id_kelas' => 1, 'hari' => 'Senin'],
            ['id_guru_mapel' => 3, 'id_jam' => 3, 'id_kelas' => 1, 'hari' => 'Senin'],
            ['id_guru_mapel' => 1, 'id_jam' => 1, 'id_kelas' => 1, 'hari' => 'Selasa'],
            ['id_guru_mapel' => 2, 'id_jam' => 2, 'id_kelas' => 1, 'hari' => 'Rabu'],
            ['id_guru_mapel' => 3, 'id_jam' => 3, 'id_kelas' => 1, 'hari' => 'Kamis'],

            // Kelas 2
            ['id_guru_mapel' => 2, 'id_jam' => 1, 'id_kelas' => 2, 'hari' => 'Senin'],
            ['id_guru_mapel' => 3, 'id_jam' => 2, 'id_kelas' => 2, 'hari' => 'Selasa'],
            ['id_guru_mapel' => 1, 'id_jam' => 3, 'id_kelas' => 2, 'hari' => 'Rabu'],
            ['id_guru_mapel' => 2, 'id_jam' => 1, 'id_kelas' => 2, 'hari' => 'Kamis'],
            ['id_guru_mapel' => 3, 'id_jam' => 2, 'id_kelas' => 2, 'hari' => 'Jumat'],

            // Kelas 3
            ['id_guru_mapel' => 3, 'id_jam' => 1, 'id_kelas' => 3, 'hari' => 'Senin'],
            ['id_guru_mapel' => 1, 'id_jam' => 2, 'id_kelas' => 3, 'hari' => 'Selasa'],
            ['id_guru_mapel' => 2, 'id_jam' => 3, 'id_kelas' => 3, 'hari' => 'Rabu'],
            ['id_guru_mapel' => 3, 'id_jam' => 1, 'id_kelas' => 3, 'hari' => 'Kamis'],
            ['id_guru_mapel' => 1, 'id_jam' => 2, 'id_kelas' => 3, 'hari' => 'Jumat'],
        ]);
    }
}