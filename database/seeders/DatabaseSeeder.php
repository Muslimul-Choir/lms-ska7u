<?php

namespace Database\Seeders;

// use App\Models\User;
use Database\Seeders\BagianSeeder;
use Database\Seeders\GuruMapelSeeder;
use Database\Seeders\GuruSeeder;
use Database\Seeders\JamBelajarSeeder;
use Database\Seeders\JurusanSeeder;
use Database\Seeders\KelasSeeder;
use Database\Seeders\Mapelseeder;
use Database\Seeders\SemesterSeeder;
use Database\Seeders\TahunAjaranSeeder;
use Database\Seeders\TingkatanSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            BagianSeeder::class,
            TingkatanSeeder::class,
            JurusanSeeder::class,
            TahunAjaranSeeder::class,
            GuruSeeder::class,
            Mapelseeder::class,
            KelasSeeder::class,
            SemesterSeeder::class,
            GuruMapelSeeder::class,
        ]);
    }
}
