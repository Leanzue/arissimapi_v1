<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\SendAttemptResult;

class SendAttemptResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'uuid' => (string) Str::uuid(),
                'date_of_sending_result' => '2025-01-21',
                'details' => 'Résultat envoyé avec succès.',
                'error_code' => '0',
                'nombre_de_tentative' => 1,
            ],
            [
                'uuid' => (string) Str::uuid(),
                'date_of_sending_result' => '2025-01-21',
                'details' => 'Erreur de connexion.',
                'error_code' => '504',
                'nombre_de_tentative' => 3,
            ],

        ];

        foreach ($data as $entry) {
            SendAttemptResult::create($entry);
        }
        SendAttemptResult::updateOrNew("2025-01-21","Résultat envoyé avec succès","0", "3");
    }
}
