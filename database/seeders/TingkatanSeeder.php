<?php

namespace Database\Seeders;

use App\Models\Tingkatan;
use Illuminate\Database\Seeder;

class TingkatanSeeder extends Seeder
{
    public function run(): void
    {
        Tingkatan::insert([
            ['nama_tingkatan' => 'X'],
            ['nama_tingkatan' => 'XI'],
            ['nama_tingkatan' => 'XII'],
        ]);
    }
}