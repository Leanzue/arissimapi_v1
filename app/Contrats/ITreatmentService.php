<?php


namespace App\Contrats;


use App\Models\SimRequest;
use App\Models\AttemptResult;

interface ITreatmentService
{
    /**
     * @param SimRequest $simrequest
     * @return AttemptResult
     */
    public function execTreatment($simrequest);
}
