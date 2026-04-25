<?php

namespace Database\Seeders;

use App\Models\GuruMapel;
use Illuminate\Database\Seeder;

class GuruMapelSeeder extends Seeder
{
    public function run(): void
    {
        GuruMapel::insert([
            [
                'id_mapel' => 1,
                'id_guru' => 1,
                'id_kelas' => 1,
                'id_semester' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_mapel' => 2,
                'id_guru' => 2,
                'id_kelas' => 2,
                'id_semester' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_mapel' => 3,
                'id_guru' => 1,
                'id_kelas' => 3,
                'id_semester' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}