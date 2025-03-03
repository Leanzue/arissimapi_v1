<?php


namespace App\Contrats;

use App\Models\SimRequest\SimRequest;
use App\Models\TreatmentAttempt\TreatmentAttempt;

/**
 * Interface IHasTreatment
 * @package App\Contrats
 *
 * @property TreatmentAttempt|null $treatmentattempt
 * @property SimRequest|null $simrequest
 *
 * @method treatmentresults(): morphMany
 */
interface IHasTreatment
{
    //
    public function treatmentstatus();
    #region Treatment Status Management
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

    // Les Etats
    public function isWaiting();
    public function isQueueing();
    public function isTrying();
    public function isRunning();
    public function isSuccess();
    public function isFailed();
    public function isMaxFailed();
    public function isSuspended();
    public function isMaxSuspended();

    //
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
}
