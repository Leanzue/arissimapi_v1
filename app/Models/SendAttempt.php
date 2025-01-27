<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SendAttempt
 * @package App\Models
 *
 * @property string $response_data
 * @property string $response_time
 *
 * @property SendAttempt $SendAttempt
 * @method static create(array $array)
 */

class SendAttempt extends BaseModel
{
    /** @use HasFactory<\Database\Factories\SendAttemptFactory> */
    use HasFactory;
    public function SendAttemptResult(): BelongsTo
    {
        return $this->belongsTo(SendAttemptResult::class, 'SendAttemptResult_id');
    }
    public function SendStatus(): BelongsTo
    {
        return $this->belongsTo(SendStatus::class, 'SendStatus_id');
    }
    public static function insertData(string $response_data, string $response_time)
    {
        self::create([
            'response_data' => $response_data,
            'response_time' => $response_time,
        ]);
    }

}
