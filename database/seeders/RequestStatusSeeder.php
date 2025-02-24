<?php

namespace Database\Seeders;

use App\Models\SendStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\RequestStatus;

class RequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            [
                'uuid' => (string) Str::uuid(),
                'priority' => '',
                'libelle' => '',
                 'code'=>'',

            ],
            [
                'uuid' => (string) Str::uuid(),
                'priority' => '',
                'libelle' => '',
                 'code'=>'',
            ],
        ];

        foreach ($data as $entry) {
            RequestStatus::create($entry);
        }
        RequestStatus::updateOrNew('mm','ll',"kkk", 'mm');
    }
}
