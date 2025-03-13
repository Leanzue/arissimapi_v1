<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SimResponse
 * @package App\Models
 *
 * @property string $iccid
 * @property string $status
 * @property string $status_change_date
 * @property string $client_key_request
 *
 * @method static SimResponse create(array $array)
 */
class SimResponse extends Model
{
    /** @use HasFactory<\Database\Factories\SimResponseFactory> */
    use HasFactory;

    protected $guarded = [];

    #region Validation Rules
    public static function defaultRules()
    {
        return [
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function updateRules($id) {
        return array_merge(self::defaultRules(),
            [

            ]
        );
    }

    public static function messagesRules()
    {
        return [
        ];
    }
    #endregion
}
