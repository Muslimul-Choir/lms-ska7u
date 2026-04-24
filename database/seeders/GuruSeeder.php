<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        Guru::insert([
            [
                'id_user' => 1,
                'nama_lengkap' => 'Wali Kelas Utama',
                'status_pengajar' => 'walikelas',
            ]
        ]);
    }
}
