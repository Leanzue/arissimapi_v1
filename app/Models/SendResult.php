<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * Class SendResult
 * @package App\Models
 *
 * @property string $result_description
 * @property string $nombre_tentative
 * @property string $date_envoi
 * @property string $error_code
 *
 * @property TreatementResult $TreatementResult
 * @method static create(array $array)
 */
class SendResult extends baseModel
{
    /** @use HasFactory<\Database\Factories\SendResultFactory> */
    use HasFactory;
    public function TreatementResult(): BelongsTo
    {
        return $this->belongsTo(TreatementResult::class, 'TreatementResult_id');
    }
    public static function insertData(string $result_description, string $nombre_tentative, string $date_envoi, string $error_code)
    {
        self::create([
            'result_description' => $result_description,
            'nombre_tentative' => $nombre_tentative,
            'date_envoi' => $date_envoi,
            'error_code' => $error_code,
        ]);
    }
}
