<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\SendResult;

class SendResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

        [
            'uuid' => (string) Str::uuid(),
            'result_description' => 'Envoi réussi sans erreurs',
            'nombre_tentative' => '1',
            'date_envoi' => now()->format('Y-m-d H:i:s'),
            'error_code' => '0',
        ],
        [
            'uuid' => (string) Str::uuid(),
            'result_description' => 'Erreur de réseau, nouvelle tentative nécessaire',
            'nombre_tentative' => '3',
            'date_envoi' => now()->subDays(1)->format('Y-m-d H:i:s'),
            'error_code' => '500',
        ],
    ];

        foreach ($data as $entry) {
            SendResult::create($entry);
       }
        SendResult::updateOrNew("result_description","nombre_tentative","date_envoi", "error code");
    }
}
