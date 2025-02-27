<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\SimRequest\RequestType;

class RequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RequestType::updateOrNew("demande_statut", "Demande de Statut","Demande de Statut")->setDefault();
        //RequestType::updateOrNew("running", "En Cours","En Cours");
        //RequestType::updateOrNew("ended", "Terminé","Terminé");
        //RequestType::updateOrNew("suspended", "Suspendu","Suspendu");
    }
}
