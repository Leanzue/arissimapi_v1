<?php


namespace App\Contrats\Treatment;


use App\Models\Treatment\Treatment;
use App\Models\Treatment\TreatmentResult;

interface ITreatmentService
{
    /**
     * @param Treatment $treatment
     * @return TreatmentResult
     */
    public function execService($treatment): TreatmentResult;

    /**
     * @return string
     */
    public static function getQueueName();
}
