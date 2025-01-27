<?php

namespace Database\Seeders;

use App\Models\TreatementResult;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TreatementResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'uuid' => (string) Str::uuid(),
                'date_tentative' => '2025-01-21',
                'details' => 'Traitement réussi',
                'resultat' => 'Succès',
                'comment' => 'Aucun problème rencontré.',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'date_tentative' => '2025-01-21',
                'details' => 'Erreur lors du traitement',
                'resultat' => 'Échec',
                'comment' => 'Problème de connexion au serveur.',
            ],
        ];

        foreach ($data as $entry) {
            TreatementResult::create($entry);
        }
    }
}
