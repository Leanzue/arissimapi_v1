<?php

namespace App\Models;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *class SimRequest
 * @package App\Models
 *
 * @property string $description
 * @property string $adresse
 * @property string $date
 * @property string $code
 *
 * @property RequestStatus $RequestStatus
 * @property RequestType $RequestType
 * @property Sim $Sim
 */

class SimRequest extends BaseModel
{
    /** @use HasFactory<\Database\Factories\SimRequestFactory> */
    use HasFactory;
    public function requeststatus(): BelongsTo
    {
        return $this->belongsTo(requeststatus::class, 'requeststatus_id');
    }
    public function requesttype(): BelongsTo
    {
        return $this->belongsTo(requesttype::class, 'requesttype_id');
    }
    public function sim(): BelongsTo
    {
        return $this->belongsTo( sim::class, 'sim_id');
    }
    public static function insertData(string $description, string $adresse, string $date, string $code)
    {
        self::create([
            'description' => $description,
            'adresse' => $adresse,
            'date' => $date,
            'code' => $code,
        ]);
    }
}
