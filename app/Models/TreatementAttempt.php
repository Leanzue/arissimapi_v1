<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class TreatementResult
 * @package App\Models
 *
 * @property string $date_debut
 * @property string $date_fin
 * @property string $resultat
 * @property string $description
 *
 * @property SendResult $SendResult
 * @method static create(string[] $array)
 */


class TreatementAttempt extends BaseModel
{
    /** @use HasFactory<\Database\Factories\TreatementAttemptFactory> */
    use HasFactory;
    public function attemptstatus(): BelongsTo
    {
        return $this->belongsTo(attemptstatus::class, 'SendResult_id');
    }
    public function TreatementResult(): BelongsTo
    {
        return $this->belongsTo(TreatementResult::class, 'TreatementResult_id');
    }
    public static function insertData(string $date_debut, string $date_fin, string $resultat, string $description)
    {
        self::create([
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'resultat' => $resultat,
            'description' => $description,
        ]);
    }
}
