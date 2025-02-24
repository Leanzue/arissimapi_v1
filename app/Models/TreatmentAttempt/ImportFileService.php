<?php


namespace App\Models\TreatmentAttempt;

use App\Models\SimRequest;
use App\Models\AttemptResult;
use App\Contrats\ITreatmentService;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use App\Imports\SimRequestResponseFilesImport;


class Import_fileService implements ITreatmentService
{
    /**
     * @var SimRequest
     */
    public $simrequest;

    public function execTreatment($simrequest)
    {
        public function importFile() {
        try {
            $import_object = Excel::import(new SimRequestResponseFilesImport($this), $this->response_file_name);
            // import success
            $this->setFileImported();
            return $import_object;
        } catch (\Exception $e) {
            $this->setFileImportFail($e->getMessage());
            return null;
        }
    }

    }

        /**
         * @return bool
         */
        public function isBatchResponseFileExists()
    {
        return File::exists($this->response_file_name);
    }

    }
}
