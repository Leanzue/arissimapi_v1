<?php


namespace App\Traits\TreatmentAttempt;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\TreatmentAttempt\TreatmentStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasTreatment
{
    /**
     * @return BelongsTo
     */
    public function treatmentstatus()
    {
        return $this->belongsTo(TreatmentStatus::class, "treatment_status_id");
    }

    #region Treatment Status Management
    public function setStart() {
        $this->date_debut = (New Carbon())->format('Y-m-d H:i:s');
        $this->save();
    }

    public function setEnded(){
        $this->date_fin = (New Carbon())->format('Y-m-d H:i:s');
        $this->save();
    }

    public function setWaiting()
    {
        // application du statut running (en utilisant le scope)
        $this->setRequestStatus(TreatmentStatus::getWaitingStatus(), "Waiting");
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
    public function setSuspended()
    {
        // application du statut Failed (en utilisant le scope)
        $this->setRequestStatus(TreatmentStatus::getSuspendedStatus(), "Suspended");
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

    public function isEnded() {
        return $this->attemptstatus->code === TreatmentStatus::getEndedStatus()->code;
    }
    public function isWaiting() {
        return $this->attemptstatus->code === TreatmentStatus::getWaitingStatus()->code;
    }
    public function isRunning() {
        return $this->attemptstatus->code === TreatmentStatus::getRunningStatus()->code;
    }
    public function isSuccess() {
        return $this->attemptstatus->code === TreatmentStatus::getSuccessStatus()->code;
    }
    public function isFailed() {
        return $this->attemptstatus->code === TreatmentStatus::getFailedStatus()->code;
    }
    public function isSuspended() {
        return $this->attemptstatus->code === TreatmentStatus::getSuspendedStatus()->code;
    }
    #endregion

}
