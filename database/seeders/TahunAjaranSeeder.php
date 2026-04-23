<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        TahunAjaran::insert([
            [
                'nama_tahun' => '2025/2026',
                'is_aktif' => 1
            ]
        ]);
    }
}