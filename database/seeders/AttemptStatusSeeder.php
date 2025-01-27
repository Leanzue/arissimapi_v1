<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\AttemptStatus;
use Illuminate\Database\Seeder;

class AttemptStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
             [
                 'uuid' => (string) Str::uuid(),
                 'nombre_essais' => '3',
                'error_code' => '500',
                'details' => 'Internal Server Error',
                'statut' => 'Échec',
                'comment' => 'Problème côté serveur'
            ],
            [
                'uuid' => (string) Str::uuid(),
                'nombre_essais' => '1',
                'error_code' => '200',
                'details' => 'Success',
                'statut' => 'Réussi',
                'comment' => 'Tout est bon'
            ],
        ];

        foreach ($data as $entry) {
            AttemptStatus::create($entry);
        }
    }
}
