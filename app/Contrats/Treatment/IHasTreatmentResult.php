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

    public function startTreatment($libelle, string $details = "En cours") : ?TreatmentResult;
    /**
     * @param string $details
     * @param TreatmentResult|null $treatmentresult
     */
    public function endTreatmentWithSuccess($details = "", $treatmentresult = null);
    /**
     * @param string $details
     * @param TreatmentResult|null $treatmentresult
     */
    public function endTreatmentWithFailure($details, $treatmentresult = null);

    #region Inserts & Update
    public function addNewTreatmentresult($resultat, $libelle, $details = null) : ?TreatmentResult;
    public function removeTreatmentResult($treatmentresult);
    public function removeTreatmentResultsAll();
    #endregion
}
