<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SendStatus
 * @package App\Models
 *
 * @property string $priority
 * @property string $libellé
 *
 * @property SendStatus $SendStatus
 * @method static create(array $array)
 */

class SendStatus extends BaseModel
{
    /** @use HasFactory<\Database\Factories\SendStatusFactory> */
    use HasFactory;

    public function SendAttempts(): HasMany {
        return $this->hasMany(SendAttempt::class);
    }
    public static function insertData(string $priority, string $libellé)
    {
        self::create([
            'priority' => $priority,
            'libellé' => $libellé,
        ]);
    }
}
