<?php

namespace Database\Seeders;


use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\TreatmentAttempt\TreatmentAttempt;

class TreatmentAttemptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TreatmentAttempt::updateOrNew("2025-10-2","","kjj", "jjjj");
        }

}
