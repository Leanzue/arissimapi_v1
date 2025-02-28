<?php


namespace App\Models\TreatmentAttempt;


use App\Contrats\ITreatmentService;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\SimRequest\SimRequest;
use App\Imports\SimRequestResponseFilesImport;

class ImportFileServie implements ITreatmentService
{
    /**
     * @var SimRequest
     */
    public $simrequest;

    /**
     * @var Treatment
     */
    public $treatment;

    /**
     * @var TreatmentResult
     */
    public $treatmentresult;

    public static function getQueueName()
    {
        return "importfileservie";
    }

    /**
     * @param Treatment $treatment
     * @return TreatmentResult
     */
    public function execTreatment($treatment): TreatmentResult
    {
        $this->simrequest = $treatment->treatmentattempt->simrequest;
        $this->treatment = $treatment;
        $this->treatmentresult = TreatmentResult::createNewResult($treatment, $this->simrequest, "Importation Fichier Reponse");

        if ($this->checkInputs()) {
            try {
                $import_object = Excel::import(new SimRequestResponseFilesImport($this->simrequest), $this->simrequest->response_file_name);

                // succes
                $this->treatmentresult->setSuccess();

            } catch (\Exception $e) {
                $this->treatmentresult->setFailed($e->getMessage());
                return $this->treatmentresult;
            }
        }
        return $this->treatmentresult;
    }

    private function checkInputs() {

        if (! $this->simrequest) {
            $this->treatmentresult->setFailed("Requete non renseigne");
            return false;
        }

        if (! $this->simrequest->sim->iccid) {
            $this->treatmentresult->setFailed("ICCID non renseigne");
            return false;
        }

        if (! $this->simrequest->isBatchResponseFileExists()) {
            $this->treatmentresult->setFailed("FICHIER non cree");
            return false;
        }

        return true;
    }
}
