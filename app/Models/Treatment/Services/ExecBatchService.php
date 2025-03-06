<?php


namespace App\Models\Treatment\Services;

use Illuminate\Support\Facades\Log;
use App\Models\Treatment\Treatment;
use App\Models\SimRequest\SimRequest;
use Illuminate\Support\Facades\Process;
use App\Models\Treatment\TreatmentResult;
use App\Contrats\Treatment\ITreatmentService;

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

    public static $BATCH_FOLDER = "C:\\xampp\\htdocs\\arissimapi\\imsistatus";
    public static $BATCH_NAME = "execsqlaris.bat";
    public static $BATCH_DELAY_SECONDS = 5;

    public static function getQueueName()
    {
        return "batchservice";
    }

    /**
     * @param Treatment $treatment
     * @return TreatmentResult
     */
    public function execService($treatment): TreatmentResult
    {
        $this->simrequest = $treatment->uppertreatment->uppertreatment;
        $this->treatment = $treatment;
        TreatmentResult::createNewServiceResult($treatment, $this->simrequest, "Execution Batch");

        // Start Attempt
        //$result = exec('start ' . self::$BATCH_FOLDER . "\\" . self::$BATCH_NAME . " " . $this->sim->iccid . " " . $this->file_prefix . " " . $this->file_extension);

        if ($this->checkRequiredInputs()) {
            $result = Process::run('start ' . self::$BATCH_FOLDER . "\\" . self::$BATCH_NAME . " " . $this->simrequest->sim ->iccid . " " . $this->simrequest->file_prefix . " " . $this->simrequest->file_extension);
            // wait for delay
            sleep(self::$BATCH_DELAY_SECONDS);

            Log::info("ExecBatchService - " . $this->treatment);

            // succes
            $this->treatment->endTreatmentWithSuccess();
        }

        return $this->treatment->latestTreatmentResult;
    }

    private function checkRequiredInputs() {

        if (! $this->simrequest->sim) {
            $this->treatment->endTreatmentWithFailure("Sim non renseigne");
            return false;
        }

        if (! $this->simrequest->sim->iccid) {
            $this->treatment->endTreatmentWithFailure("ICCID non renseigne");
            return false;
        }

        if (! $this->simrequest->file_prefix) {
            $this->treatment->endTreatmentWithFailure("PREFIX fichier non renseigne");
            return false;
        }

        if (! $this->simrequest->file_extension) {
            $this->treatment->endTreatmentWithFailure("EXTENSION fichier non renseigne");
            return false;
        }

        return true;
    }
}
