<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

            $this->call([
                StatusSeeder::class,
                RequestStatusSeeder::class,
                RequestTypeSeeder::class,
                SimSeeder::class,
                SimRequestSeeder::class,
                TreatmentStatusSeeder::class,
                //TreatmentResultSeeder::class,
                //TreatmentAttemptSeeder::class,
            ]);
    }
}
