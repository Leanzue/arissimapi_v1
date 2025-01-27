<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *class Sim
 * @package App\Models
 *
 * @property string $iccid
 * @property string $imsi
 * @property string $puk
 * @property string $pin
 *
 * @property SimRequest $SimRequest
 */
class Sim extends BaseModel
{
    /** @use HasFactory<\Database\Factories\SimFactory> */
    use HasFactory;

    public function SimRequests(): HasMany
    {
        return $this->hasMany(SimRequest::class);
    }   public static function insertData(string $iccid, string $imsi, string $puk, string $pin)
{
    self::create([
        'iccid' => $iccid,
        'imsi' => $imsi,
        'puk' => $puk,
        'pin' => $pin,

       ]);
     }
}
