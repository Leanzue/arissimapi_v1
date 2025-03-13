<?php


namespace App\Traits\Treatment;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Treatment\TreatmentStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Trait HasTreatmentStatus
 * @package App\Traits\Treatment
 *
 * @property TreatmentStatus $treatmentstatus
 */
trait HasTreatmentStatus
{
    /**
     * @return BelongsTo
     */
    public function treatmentstatus()
    {
        return $this->belongsTo(TreatmentStatus::class, "treatment_status_id");
    }

    #region Treatment Status Management
    public function setWaiting()
    {
        // application du statut running (en utilisant le scope)
        $this->setRequestStatus(TreatmentStatus::getWaitingStatus(), "Waiting");
    }

    public function setQueueing()
    {
        // application du statut queueing (en utilisant le scope)
        $this->setRequestStatus(TreatmentStatus::getQueueingStatus(), "Queueing");
    }

    public function setTrying()
    {
        // application du statut trying (en utilisant le scope)
        $this->setRequestStatus(TreatmentStatus::getTryingStatus(), "Trying");
    }

    public function setRunning()
    {
        // application du statut running (en utilisant le scope)
        $this->setRequestStatus(TreatmentStatus::getRunningStatus(), "Running");
    }

    public function setSuccess()
    {
        // application du statut Success (en utilisant le scope)
        $this->setRequestStatus(TreatmentStatus::getSuccessStatus(), "Success");
    }

    public function setFailed()
    {
        // application du statut Failed (en utilisant le scope)
        $this->setRequestStatus(TreatmentStatus::getFailedStatus(), "Failed");
    }

    public function setMaxFailed()
    {
        // application du statut Failed (en utilisant le scope)
        $this->setRequestStatus(TreatmentStatus::getMaxFailedStatus(), "Max Failed");
    }

    public function setSuspended()
    {
        // application du statut suspended (en utilisant le scope)
        $this->setRequestStatus(TreatmentStatus::getSuspendedStatus(), "Suspended");
    }

    public function setMaxSuspended()
    {
        // application du statut maxsuspended (en utilisant le scope)
        $this->setRequestStatus(TreatmentStatus::getMaxSuspendedStatus(), "Max Suspended");
    }


    /**
     * @param TreatmentStatus $requeststatus
     * @param string $label
     */
    private function setRequestStatus($requeststatus, $label) {
        if ($requeststatus) {
            // si ce status existe, association de la cle etrangere
            $this->treatmentstatus()->associate($requeststatus)->save();
        }else {
            Log::error("Status " . $label. " not found");
        }
    }

    // Les Etats
    public function isWaiting() {
        return $this->treatmentstatus->code === TreatmentStatus::getWaitingStatus()->code;
    }
    public function isQueueing() {
        return $this->treatmentstatus->code === TreatmentStatus::getQueueingStatus()->code;
    }
    public function isTrying() {
        return $this->treatmentstatus->code === TreatmentStatus::getTryingStatus()->code;
    }
    public function isRunning() {
        return $this->treatmentstatus->code === TreatmentStatus::getRunningStatus()->code;
    }
    public function isSuccess() {
        return $this->treatmentstatus->code === TreatmentStatus::getSuccessStatus()->code;
    }
    public function isFailed() {
        return $this->treatmentstatus->code === TreatmentStatus::getFailedStatus()->code;
    }
    public function isMaxFailed() {
        return $this->treatmentstatus->code === TreatmentStatus::getMaxFailedStatus()->code;
    }
    public function isSuspended() {
        return $this->treatmentstatus->code === TreatmentStatus::getSuspendedStatus()->code;
    }
    public function isMaxSuspended() {
        return $this->treatmentstatus->code === TreatmentStatus::getMaxSuspendedStatus()->code;
    }
    #endregion
}
