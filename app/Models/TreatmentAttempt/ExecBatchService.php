<?php


namespace App\Models\TreatmentAttempt;


use App\Models\SimRequest;
use App\Models\AttemptResult;
use App\Contrats\ITreatmentService;
use Illuminate\Support\Facades\Process;
use function Carbon\this;

class ExecBatchService implements ITreatmentService
{
    /**
     * @var SimRequest
     */
    public $simrequest;

    public static $BATCH_FOLDER = "C:\\xampp\\htdocs\\arissimapi\\imsistatus";
    public static $BATCH_NAME = "execsqlaris.bat";
    public static $BATCH_DELAY_SECONDS = 5;

    /**
     * @param SimRequest $simrequest
     * @return AttemptResult|void
     */
    public function execTreatment($simrequest)
    {
        $this->simrequest = $simrequest;
        // Start Attempt
        //$result = exec('start ' . self::$BATCH_FOLDER . "\\" . self::$BATCH_NAME . " " . $this->sim->iccid . " " . $this->file_prefix . " " . $this->file_extension);

        $result = Process::run('start ' . self::$BATCH_FOLDER . "\\" . self::$BATCH_NAME . " " . $this->simrequest->sim->iccid . " " . $simrequest->file_prefix . " " . $simrequest->file_extension);
        // wait for delay
        sleep(self::$BATCH_DELAY_SECONDS);

        // Try Parse Batch Response File

        $this->tryParseBatchResponseFile();

        //Envoyer la

        // $this->sendBatchCompletedNotification();
        // End Attempt
    }

    public function tryParseBatchResponseFile()
    {
        //dd($this->response_file_name, $this->isBatchResponseFileExists());
        // check existance fichier
        if (!$this->simrequest->isBatchResponseFileExists()) {
            $this->simrequest->setWaitingParse();
            return;
        }
        // le fichier existe
    }
}
