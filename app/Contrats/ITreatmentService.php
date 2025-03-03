<?php


namespace App\Contrats;


use App\Models\TreatmentAttempt\Treatment;
use App\Models\TreatmentAttempt\TreatmentResult;

interface ITreatmentService
{
    /**
     * @param Treatment $treatment
     * @return TreatmentResult
     */
    public function execTreatment($treatment): TreatmentResult;

    /**
     * @return string
     */
    public static function getQueueName();
}
