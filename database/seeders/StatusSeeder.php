<?php

namespace Database\Seeders;

use App\Models\Status; // Assurez-vous d'importer le bon modèle
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Actif',
                'code' => 'ACTIVE',
                'style' => 'green',
                'is_default' => true,
                'description' => 'Le statut actif pour les enregistrements.',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Inactif',
                'code' => 'INACTIVE',
                'style' => 'red',
                'is_default' => false,
                'description' => 'Le statut inactif pour les enregistrements.',
            ],
            // Ajoutez d'autres entrées selon vos besoins
        ];

        foreach ($data as $entry) {
            Status::create($entry);
        }
    }
}
