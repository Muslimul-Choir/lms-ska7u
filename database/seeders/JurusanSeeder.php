<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    
    public function run(): void
    {
        Jurusan::insert([
            ['nama_jurusan' => 'RPL'],
            ['nama_jurusan' => 'TKJ'],
            ['nama_jurusan' => 'DKV'],
            ['nama_jurusan' => 'TITL'],
            ['nama_jurusan' => 'TJAT'],
        ]);
    }
}