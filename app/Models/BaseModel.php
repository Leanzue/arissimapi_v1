<?php

namespace App\Models;

use App\Traits\BaseTrait;
use App\Traits\HasCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method changeStatus($first)
 * @property mixed status
 */
class BaseModel extends Model
{
    use BaseTrait, HasCreator;

    public function getRouteKeyName() { return 'uuid'; }

    #region Eloquent Relationships

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updator() {
        return $this->belongsTo(User::class, 'updated_by');
    }

    #endregion

    #region Accessors & Mutators

    public function getIsActiveAttribute() {
        return ($this->status->code === 'active');
    }
    #endregion

    #region Scopes

    public function scopeDefault($query, $exclude = []) {
        return $query
            ->where('is_default', true)->whereNotIn('id', $exclude);
    }

    public function scopeActive($query) {
        return $query
            ->where('status_id', Status::active()->first()->id);
    }

    public function activate() {
        $this->changeStatus(Status::active()->first());
    }
    public function deactivate() {
        $this->changeStatus(Status::inactive()->first());
    }
      public function saveObject(bool $save) {
    if ($save) {
        $this->save();
    }


#endregion

   }
}
