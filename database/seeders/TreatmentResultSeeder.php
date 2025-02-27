<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\TreatmentAttempt\TreatmentResult;

class TreatmentResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {TreatmentResult::updateOrNew("2025-01-21 ","Traitement réussi","Succès", "Aucun problème rencontré");


    }



}
