<?php


namespace App\Contrats\Treatment;


use App\Models\Treatment\TreatmentResult;

/**
 * Interface IHasTreatmentResult
 * @package App\Contrats\Treatment
 *
 * @property TreatmentResult[] $treatmentresults
 * @property TreatmentResult|null $latestTreatmentResult
 * @property TreatmentResult|null $oldestTreatmentResult
 */
interface IHasTreatmentResult
{
    #region Relationships
    public function treatmentresults();
    public function latestTreatmentResult();
    public function oldestTreatmentResult();
    #endregion

    #region Inserts & Update
    public function addNewTreatmentresult($resultat, $libelle, $details = null) : ?TreatmentResult;
    public function removeTreatmentResult($treatmentresult);
    public function removeTreatmentResultsAll();
    #endregion
}
