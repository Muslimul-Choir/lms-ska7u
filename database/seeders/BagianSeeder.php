<?php

namespace Database\Seeders;

use App\Models\Bagian;
use Illuminate\Database\Seeder;

class BagianSeeder extends Seeder
{
    
    public function run(): void
    {
        Bagian::insert([
            ['nama_bagian' => '1', 'deskripsi' => 'Bagian 1'],
            ['nama_bagian' => '2', 'deskripsi' => 'Bagian 2'],
            ['nama_bagian' => '3', 'deskripsi' => 'Bagian 3'],
            ['nama_bagian' => 'Axioo', 'deskripsi' => 'Kelas industri Axioo'],
            ['nama_bagian' => 'Gamelab', 'deskripsi' => 'Kelas industri Gamelab'],
        ]);
    }
}