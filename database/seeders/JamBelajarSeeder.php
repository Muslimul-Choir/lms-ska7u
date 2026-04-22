<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JamBelajar;

class JamBelajarSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'jam_mulai' => '07:00',
                'jam_selesai' => '08:00',
            ],
            [
                'jam_mulai' => '08:00',
                'jam_selesai' => '09:00',
            ],
            [
                'jam_mulai' => '09:00',
                'jam_selesai' => '10:00',
            ],
            [
                'jam_mulai' => '10:15',
                'jam_selesai' => '11:15',
            ],
        ];

        foreach ($data as $item) {
            JamBelajar::create($item);
        }
    }
}