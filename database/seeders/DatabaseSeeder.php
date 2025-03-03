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
                TreatmentStatusSeeder::class,
                RequestTypeSeeder::class,
                //SimSeeder::class,
                //SimRequestSeeder::class,
                //TreatmentResultSeeder::class,
                //TreatmentAttemptSeeder::class,
            ]);
    }
}
