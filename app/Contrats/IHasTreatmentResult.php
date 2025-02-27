<?php


namespace App\Contrats;


use App\Models\TreatmentAttempt\TreatmentResult;

interface IHasTreatmentResult {

    public function treatmentresults();
    public function latestTreatmentResult();
    public function oldestTreatmentResult();

    public function addNewTreatmentresult($resultat, $libelle, $details = null) : ?TreatmentResult;
    public function removeTreatmentResult($treatmentresult);
    public function removeTreatmentResultsAll();

}
