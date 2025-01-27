<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class TreatementResult
 * @package App\Models
 *
 * @property string $date_tentative
 * @property string $details
 * @property string $resultat
 * @property string $comment
 *
 * @property SendResult $SendResult
 * @method static create(string[] $entry)
 */
class TreatementResult extends baseModel
{
    /** @use HasFactory<\Database\Factories\TreatementResultFactory> */
    use HasFactory;


    public function SendResult(): HasMany
    {
        return $this->hasMany(SendResult::class);
    }
    public static function insertData(string $date_tentative, string $details, string $resultat, string $comment)
    {
        self::create([
            'date_tentative' => $date_tentative,
            'details' => $details,
            'resultat' => $resultat,
            'comment' => $comment,
        ]);
     }
}

