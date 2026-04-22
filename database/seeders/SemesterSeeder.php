<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        $semesters = [
            ['nama_semester' => 'Semester 1'],
            ['nama_semester' => 'Semester 2'],
            ['nama_semester' => 'Semester 3'],
            ['nama_semester' => 'Semester 4'],
            ['nama_semester' => 'Semester 5'],
            ['nama_semester' => 'Semester 6'],
            ['nama_semester' => 'Semester 7'],
            ['nama_semester' => 'Semester 8'],
        ];

        foreach ($semesters as $semester) {
            Semester::firstOrCreate(
                ['nama_semester' => $semester['nama_semester']]
            );
        }

        $this->command->info('SemesterSeeder: ' . count($semesters) . ' data berhasil di-seed.');
    }
}