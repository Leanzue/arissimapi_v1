<?php


namespace App\Models\Treatment\Services;

use App\Models\Treatment\Treatment;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\SimRequest\SimRequest;
use App\Models\Treatment\TreatmentResult;
use App\Contrats\Treatment\ITreatmentService;
use App\Imports\SimRequestResponseFilesImport;

class ImportFileService implements ITreatmentService
{
    /**
     * @var SimRequest
     */
    public $simrequest;

    /**
     * @var Treatment
     */
    public $treatment;

    public static function getQueueName()
    {
        return "importfileservice";
    }

    /**
     * @param Treatment $treatment
     * @return TreatmentResult
     */
    public function execService($treatment): TreatmentResult
    {
        $this->simrequest = $treatment->uppertreatment->uppertreatment;
        $this->treatment = $treatment;
        TreatmentResult::createNewServiceResult($treatment, $this->simrequest, "Importation Fichier Reponse");

        if ($this->checkRequiredInputs()) {
            try {
                $import_object = Excel::import(new SimRequestResponseFilesImport($this->simrequest), $this->simrequest->response_file_name);
                // TODO: remettre la bonne instruction
                // succes
                //$this->treatment->endTreatmentWithSuccess();
                $this->treatment->endTreatmentWithFailure();

            } catch (\Exception $e) {
                $this->treatment->endTreatmentWithFailure($e->getMessage());
                return $this->treatment->latestTreatmentResult;
            }
        }
        return $this->treatment->latestTreatmentResult;
    }

    private function checkRequiredInputs() {

        if (! $this->simrequest) {
            $this->treatment->endTreatmentWithFailure("Requete non renseigne");
            return false;
        }

        if (! $this->simrequest->sim->iccid) {
            $this->treatment->endTreatmentWithFailure("ICCID non renseigne");
            return false;
        }

        if (! $this->simrequest->is_batch_response_file_exists) {
            $this->treatment->endTreatmentWithFailure("FICHIER non cree");
            return false;
        }

        return true;
    }
}
