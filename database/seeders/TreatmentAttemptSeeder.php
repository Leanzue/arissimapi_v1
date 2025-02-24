<?php

namespace Database\Seeders;

use App\Models\TreatmentAttempt; // Assurez-vous d'importer le bon modèle
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TreatmentAttemptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'uuid' => (string) Str::uuid(),
                'date_debut' => '2025-01-21 10:00:00',
                'date_fin' => '2025-01-21 10:30:00',
                'description' => 'Tentative de traitement réussie sans erreurs.',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'date_debut' => '2025-01-21 11:00:00',
                'date_fin' => '2025-01-21 11:15:00',
                'description' => 'Tentative de traitement échouée en raison d\'une erreur de connexion.',
            ],
            // Ajoutez d'autres entrées selon vos besoins
        ];

        foreach ($data as $entry) {
            TreatmentAttempt::create($entry);
        }
        TreatmentAttempt::updateOrNew("Actif ","204","green", "true","Le statut actif pour les enregistrements");
    }
}
