<?php


namespace App\Traits;


use Illuminate\Support\Str;

trait UuidTrait
{
    public static function generateUuid()
    {
        return Str::orderedUuid();
    }

    public static function getByUuid(string $uuid): ?IsBaseModel {
        return self::where('uuid', $uuid)->first();
    }
}
