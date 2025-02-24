<?php

namespace App\Console\Commands\SimRequest;

use Illuminate\Console\Command;
use App\Models\SimRequest;

/**
 * @method runBatch(SimRequest $waiting_request)
 */
class SimRequestRunBatch extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simrequest:run-batch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execution du Batch MS-DOS pour les requetes nouvellement crees';

    /**
     * Execute the console command.
     */
    public function handle() {
        // 1. Recuperer les requetes dans le status
        $waiting_requests = SimRequest::getWaitingRequests();

        if (is_null($waiting_requests)) {
            // retourner un message pour signifier
            $this->error("aucune requete en attente");
            \Log::info("Aucune Requete en attente !");
        } else {
            // 2. Parcour des requetes en vue de:
            foreach ($waiting_requests as $waiting_request){
                // 3.passer le status de la requete a encours de traitement
                $waiting_request->setRunning();
                // 4.executer le batch pour la requete en cours
                $waiting_request->execBatch();
            // Ajouter un message de confirmation pour la fin du traitement
            $this->info("Batch exécuté avec succès.");
            \Log::info("Batch exécuté avec succès pour toutes les requêtes en attente.");
            }
        }
    }
}
