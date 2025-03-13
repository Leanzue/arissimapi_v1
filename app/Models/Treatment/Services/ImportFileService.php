<?php


namespace App\Models\Treatment\Services;

use App\Models\Treatment\Treatment;
use Illuminate\Support\Facades\Log;
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
                $import_object = new SimRequestResponseFilesImport($this->simrequest); //Excel::import(new SimRequestResponseFilesImport($this->simrequest), $this->simrequest->response_file_name);
                $import_object->import($this->simrequest->response_file_name, null, \Maatwebsite\Excel\Excel::CSV);

                Log::info("Fin Importation");
                Log::info("totalrows: " . $import_object->total_rows);
                Log::info("nb_row_imported: " . $import_object->nb_row_imported);

                Log::info("error_message_str: " . $import_object->error_message_str);
                Log::info("import failures: " . json_encode( $import_object->failures() ));

                // On verifie le resultat de l'importation
                if ($import_object->nb_row_imported === 1) {
                    $this->treatment->endTreatmentWithSuccess();
                } else {
                    $error_msg = "";

                    foreach ($import_object->failures() as $failure) {
                        $error_msg =  ($error_msg === "") ? "" : $error_msg . " | " ;
                        $error_msg = $error_msg . "Row: " . $failure->row() . "; "; // row that went wrong
                        $error_msg = $error_msg . "Attribute: " . $failure->attribute() . "; ";; // either heading key (if using heading row concern) or column index
                        $error_msg = $error_msg . "Errors: " . json_encode( $failure->errors() ) . "; ";; // Actual error messages from Laravel validator
                        $error_msg = $error_msg . "Values: " . $failure->values()[$failure->attribute()] . "; ";; // The values of the row that has failed.
                    }

                    if ( $import_object->error_message_str !== "" ) {
                        $error_msg =  ($error_msg === "") ?
                            $import_object->error_message_str :
                            $error_msg . " | " . $import_object->error_message_str;
                    }

                    $this->treatment->endTreatmentWithFailure($error_msg);
                }

            } catch (\Exception $e) {
                $this->treatment->endTreatmentWithFailure($e->getMessage());
                return $this->returnServiceResult();
            }
        }
        return $this->returnServiceResult();
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

    private function returnServiceResult() {
        $this->treatment->load('latestTreatmentResult');
        return $this->treatment->latestTreatmentResult;
    }
}
