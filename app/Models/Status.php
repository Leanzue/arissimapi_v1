<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class Status
 * @package App\Models
 *
 * @property string $name
 * @property string $code
 * @property string $style
 * @property string $is_default
 * @property string $description
 *
 * @method static active()
 * @method static inactive()
 * @method static Status|null default()
 */
class Status extends Model
{
    /** @use HasFactory<\Database\Factories\StatusFactory> */
    use HasFactory;

    public static function insertData(string $name, string $code, string $style, string $is_default, string $description)
    {
        self::create([
            'name' => $name,
            'code' => $code,
            'style' => $style,
            'is_default' => $is_default,
            'description' => $description,
        ]);
    }

    /**
     * @return Status|null
     */
    public static function default(): Status
    {
        return self::where('is_default', true)->first();
    }
}

