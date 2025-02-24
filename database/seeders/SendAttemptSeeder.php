<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\SendAttempt;
use Illuminate\Database\Seeder;
use App\Models\SendAttemptResult;

class SendAttemptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'uuid' => (string) Str::uuid(),
                'response_data' => 'Réponse créée avec succès',
                'response_time' => '2025-01-15 10:30:00',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'response_data' => 'Réponse mise à jour avec succès',
                'response_time' => '2025-01-15 10:35:00',
            ],
        ];

        foreach ($data as $entry) {
            SendAttempt::create($entry);
        }
        SendAttempt::updateOrNew("Réponse créée avec succès","2025-01-15 10:30:00");
    }
}
