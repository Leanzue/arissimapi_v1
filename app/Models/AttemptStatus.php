<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AttemptStatus
 * @package App\Models
 *
 * @property string $nombre_essais
 * @property string $error_code
 * @property string $details
 * @property string $statut
 * @property string $comment
 *
 * @property TreatementAttempt $treatementattempts
 * @method static create(string[] $array)
 */
class AttemptStatus extends Model
{
    use HasFactory;

    public function treatementattempts(): HasMany {
        return $this->hasMany(TreatementAttempt::class);
    }

    public static function insertData(string $nombre_essais, string $error_code, string $details, string $statut, string $comment)
    {
        self::create([
            'nombre_essais' => $nombre_essais,
            'error_code' => $error_code,
            'details' => $details,
            'statut' => $statut,
            'comment' => $comment,
        ]);
    }
}
