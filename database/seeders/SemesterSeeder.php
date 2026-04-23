<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan TahunAjaranSeeder sudah dijalankan
        $tahunAjaranAktif = \App\Models\TahunAjaran::where('is_aktif', true)->first();

        if (!$tahunAjaranAktif) {
            $this->command->error('TahunAjaranSeeder belum dijalankan atau tidak ada tahun ajaran aktif.');
            return;
        }

        $semesters = [
            ['nama_semester' => 'Semester 1', 'id_tahun_ajaran' => $tahunAjaranAktif->id, 'is_aktif' => true],
            ['nama_semester' => 'Semester 2', 'id_tahun_ajaran' => $tahunAjaranAktif->id, 'is_aktif' => false],
            ['nama_semester' => 'Semester 3', 'id_tahun_ajaran' => $tahunAjaranAktif->id, 'is_aktif' => false],
            ['nama_semester' => 'Semester 4', 'id_tahun_ajaran' => $tahunAjaranAktif->id, 'is_aktif' => false],
            ['nama_semester' => 'Semester 5', 'id_tahun_ajaran' => $tahunAjaranAktif->id, 'is_aktif' => false],
            ['nama_semester' => 'Semester 6', 'id_tahun_ajaran' => $tahunAjaranAktif->id, 'is_aktif' => false],
            ['nama_semester' => 'Semester 7', 'id_tahun_ajaran' => $tahunAjaranAktif->id, 'is_aktif' => false],
            ['nama_semester' => 'Semester 8', 'id_tahun_ajaran' => $tahunAjaranAktif->id, 'is_aktif' => false],
        ];

        foreach ($semesters as $semester) {
            Semester::firstOrCreate(
                ['nama_semester' => $semester['nama_semester'], 'id_tahun_ajaran' => $semester['id_tahun_ajaran']],
                ['is_aktif' => $semester['is_aktif']]
            );
        }

        $this->command->info('SemesterSeeder: ' . count($semesters) . ' data berhasil di-seed.');
    }
}