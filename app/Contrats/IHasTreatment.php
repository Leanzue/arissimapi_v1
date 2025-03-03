<?php


namespace App\Contrats;


interface IHasTreatment
{
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
}
