<?php


namespace App\Contrats\Treatment;


use App\Models\Treatment\TreatmentStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Interface IHasTreatmentStatus
 * @package App\Contrats\Treatment
 *
 * @property TreatmentStatus|null $treatmentstatus
 */
interface IHasTreatmentStatus
{
    #region Relationships
    /**
     * @return belongsTo
     */
    public function treatmentstatus();
    #endregion

    #region Status Setters
    public function setStart();
    public function setEnded();
    public function setWaiting();
    public function setQueueing();
    public function setTrying();
    public function setRunning();
    public function setSuccess();
    public function setFailed();
    public function setMaxFailed();
    public function setSuspended();
    public function setMaxSuspended();
    #endregion

    #region Status States
    public function isWaiting();
    public function isQueueing();
    public function isTrying();
    public function isRunning();
    public function isSuccess();
    public function isFailed();
    public function isMaxFailed();
    public function isSuspended();
    public function isMaxSuspended();
    #endregion

    #region Sub-Treatment Status
    /**
     * @param IHasTreatment $subtreatment
     */
    public function subTreatmentDispatched($subtreatment);

    /**
     * @param IHasTreatment $subtreatment
     */
    public function subTreatmentFailed($subtreatment);

    /**
     * @param IHasTreatment $subtreatment
     */
    public function subTreatmentSucceed($subtreatment);
    #endregion
}
