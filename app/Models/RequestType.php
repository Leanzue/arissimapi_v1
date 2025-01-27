<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
*class RequestType
* @package App\Models
*
* @property string $action
* @property string $libellé
*
* @property SimRequest $SimRequest
 * @method static create(array $array)
 */
class RequestType extends BaseModel
{
    /** @use HasFactory<\Database\Factories\RequestTypeFactory> */
    use HasFactory;

    public function SimRequests(): HasMany
    {
        return $this->hasMany(SimRequest::class);
    }
    public static function insertData(string $action, string $libellé)
    {
        self::create([
            'action' => $action,
            'libellé' => $libellé,

        ]);
    }
}

