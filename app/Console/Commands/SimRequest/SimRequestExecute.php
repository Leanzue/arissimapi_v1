<?php

namespace App\Console\Commands\SimRequest;

use Illuminate\Console\Command;
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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Recuperer les requetes dans le status
        $waiting_requests = SimRequest::getWaitingRequests();
        //dd(count($waiting_requests));
        if (count($waiting_requests) === 0) {
            // retourner un message pour signifier
            $this->error("aucune requete a executer");
            \Log::info("Aucune Requete a executer !");
        } else {
            // 2. Parcour des requetes en vue de:
            foreach ($waiting_requests as $waiting_request){
                $waiting_request->execRequest();
                // Ajouter un message de confirmation pour la fin du traitement
                $this->info("SimRequest exécuté avec succès.");
                \Log::info("SimRequest exécuté avec succès pour toutes les requêtes a executer.");
            }
        }
    }
}
