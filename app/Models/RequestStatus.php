<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class RequestStatus
 * @package App\Models
 *
 * @property string $priority
 * @property string $libellé
 *
 * @property SimRequest $SimRequest
 * @method static create(array $validatedData)
 */
class RequestStatus extends BaseModel

{    use HasFactory;

       public function SimRequests(): HasMany
  {
    return $this->hasMany(SimRequest::class);
   }
    public static function insertData(string $priority, string $libellé)
    {
        self::create([
            'priority' => $priority,
            'libellé' => $libellé,

        ]);
    }
}
