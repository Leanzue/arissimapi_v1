<?php


namespace App\Traits;


use App\Models\Status;

trait StatusTrait
{
    public function setDefaultStatus() {
        if (empty($this->status_id)) {
            $default_status = Status::default();
            if ($default_status) {
                $this->status_id = $default_status->first()->id;
            }
        }
    }

    public function activateStatus() {
        $active_status = Status::active()->first();
        if ($active_status) {
            $this->update([
                'status_id' => $active_status->id
            ]);
        }
    }

    public function deactivateStatus() {
        $inctive_status = Status::inactive()->first();
        if ($inctive_status) {
            $this->update([
                'status_id' => $inctive_status->id
            ]);
        }
    }

    public function isActive() {
        //return $this->is_local || $this->is_ldap;
        return Status::active()->first() && $this->status_id === Status::active()->first()->id;
    }

    public function setStatus(Status $status = null, $save = false) {
        if ( is_null($status) ) {
            $this->status()->disassociate();
        } else {
            $this->status()->associate($status);
        }

        if ($save) { $this->save(); }

        return $this;
    }
}
