<?php

namespace App\Console\Commands\SimRequest;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Treatment\Treatment;
use App\Models\SimRequest\SimRequest;

class SimRequestExecute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simrequest:exec';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'excution des requetes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info("Exec SimRequestExecute.");
        // 1. Recuperer les requetes dans le status
        $waiting_requests = SimRequest::getTreatmentsToBeExecuted();
        //dd(count($waiting_requests));
        if (count($waiting_requests) === 0) {
            // retourner un message pour signifier
            $this->info("Aucune Requete a executer !");
            Log::info("Aucune Requete a executer !");
        } else {
            // 2. Parcour des requetes en vue de:
            foreach ($waiting_requests as $waiting_request){
                $waiting_request->execRequest();
                // Ajouter un message de confirmation pour la fin du traitement
                $this->info("SimRequest (" . $waiting_request->id . ") exécuté avec succès.");
                Log::info("SimRequest (" . $waiting_request->id . ") exécuté avec succès pour toutes les requêtes a executer.");
            }
        }
    }
}
