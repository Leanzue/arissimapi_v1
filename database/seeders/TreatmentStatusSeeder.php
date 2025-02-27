<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TreatmentAttempt\TreatmentStatus;

class TreatmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TreatmentStatus::updateOrNew("waiting", "En Attente","En Attente");
        TreatmentStatus::updateOrNew("running", "En Cours","En Cours");
        TreatmentStatus::updateOrNew("ended", "Terminé","Terminé");
        TreatmentStatus::updateOrNew("success", "Succès","Succès");
        TreatmentStatus::updateOrNew("failed", "Echec","Echec");
        TreatmentStatus::updateOrNew("suspended", "Suspendu","Suspendu");
    }
}
