<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        Semester::insert([
            ['nama_semester' => 'Ganjil'],
            ['nama_semester' => 'Genap'],
        ]);
    }
}