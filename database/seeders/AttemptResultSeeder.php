<?php

namespace Database\Seeders;

use App\Models\AttemptResult;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class AttemptResultSeeder extends Seeder
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
            AttemptResult::create($entry);
        }
        AttemptResult::updateOrNew("2025-01-21 ","Traitement réussi","Succès", "Aucun problème rencontré");
    }
}
