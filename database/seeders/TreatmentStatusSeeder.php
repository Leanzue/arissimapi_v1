<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Treatment\TreatmentStatus;

class TreatmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TreatmentStatus::updateOrNew("waiting", "En Attente","En Attente");
        TreatmentStatus::updateOrNew("queueing", "En File d Attente","En File d Attente");
        TreatmentStatus::updateOrNew("trying", "Tentative en cours","Tentative en cours");
        TreatmentStatus::updateOrNew("running", "En Cours","En Cours (un traitement, au moins, est en cours)");
        TreatmentStatus::updateOrNew("success", "Succès","Succès");
        TreatmentStatus::updateOrNew("failed", "Echec","Echec");
        TreatmentStatus::updateOrNew("maxfailed", "Maximum Echec Atteint","Maximum Echec Atteint");
        TreatmentStatus::updateOrNew("suspended", "Suspendu","Suspendu");
        TreatmentStatus::updateOrNew("maxsuspended", "Max Suspendu","Max Suspendu");
    }
}
