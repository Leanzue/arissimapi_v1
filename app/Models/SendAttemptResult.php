<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class SendAttemptResult
 * @package App\Models
 *
 * @property string $date_of_sending_result
 * @property string $details
 * @property string $error_code
 * @property string $nombre_de_tentative
 *
 * @property SendAttempt $SendAttempt
 */
class SendAttemptResult extends BaseModel

{   /** @use HasFactory<\Database\Factories\SimFactory> */
    use HasFactory;


    public function SendAttempts(): HasMany {
        return $this->hasMany(SendAttempt::class);
    }

    public static function insertData(string $date_of_sending_results, string $details, string $error_code, string $nombre_de_tentative )
    {
        self::create([
            'date_of_sending_results' => $date_of_sending_results,
            'edetails' => $details,
            'error_code' => $error_code,
            'nombre_de_tentative' => $nombre_de_tentative,
        ]);
    }
}
