<?php


namespace App\Models\TreatmentAttempt;

use App\Contrats\ITreatmentService;
use App\Models\SimRequest\SimRequest;
use Illuminate\Support\Facades\Process;

class ExecBatchService implements ITreatmentService
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

    public static $BATCH_FOLDER = "C:\\xampp\\htdocs\\arissimapi\\imsistatus";
    public static $BATCH_NAME = "execsqlaris.bat";
    public static $BATCH_DELAY_SECONDS = 5;

    /**
     * @param Treatment $treatment
     * @return TreatmentResult
     */
    public function execTreatment($treatment): TreatmentResult
    {
        $this->simrequest = $treatment->treatmentattempt->simrequest;
        $this->treatment = $treatment;
        $this->treatmentresult = TreatmentResult::createNewResult($treatment, $this->simrequest, "Execution Batch");

        // Start Attempt
        //$result = exec('start ' . self::$BATCH_FOLDER . "\\" . self::$BATCH_NAME . " " . $this->sim->iccid . " " . $this->file_prefix . " " . $this->file_extension);

        if ($this->checkInputs()) {
            $result = Process::run('start ' . self::$BATCH_FOLDER . "\\" . self::$BATCH_NAME . " " . $this->simrequest->sim ->iccid . " " . $this->simrequest->file_prefix . " " . $this->simrequest->file_extension);
            // wait for delay
            sleep(self::$BATCH_DELAY_SECONDS);

            // succes
            $this->treatmentresult->setSuccess();
        }

        return $this->treatmentresult;
    }

    private function checkInputs() {

        if (! $this->simrequest->sim) {
            $this->treatmentresult->setFailed("Sim non renseigne");
            return false;
        }

        if (! $this->simrequest->sim->iccid) {
            $this->treatmentresult->setFailed("ICCID non renseigne");
            return false;
        }

        if (! $this->simrequest->file_prefix) {
            $this->treatmentresult->setFailed("PREFIX fichier non renseigne");
            return false;
        }

        if (! $this->simrequest->file_extension) {
            $this->treatmentresult->setFailed("EXTENSION fichier non renseigne");
            return false;
        }

        return true;
    }
}
