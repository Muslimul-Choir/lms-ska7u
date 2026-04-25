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
                'email' => 'walikelas@example.com',
                'status_pengajar' => 'walikelas',
            ],
            [
                'id_user' => 2,
                'nama_lengkap' => 'Guru Matematika',
                'email' => 'guru.mtk@example.com',
                'status_pengajar' => 'pengajar',
            ]
        ]);

        $this->command->info(count(Guru::all()) . ' data guru berhasil di-seed.');
    }
}
