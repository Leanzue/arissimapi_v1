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
                RequestTypeSeeder::class,
                RequestStatusSeeder::class,
                SimSeeder::class,
                SimRequestSeeder::class,
                AttemptStatusSeeder::class,
                TreatementResultSeeder::class,
                SendResultSeeder::class,
                TreatementAttemptSeeder::class,
                SendStatusSeeder::class,
                SendAttemptResultSeeder::class,
                SendAttemptSeeder::class,


            ]);
    }
}
