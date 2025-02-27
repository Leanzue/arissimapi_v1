<?php


namespace App\Traits\Code;

use Illuminate\Support\Str;

trait HasCode
{
    /**
     * @return string
     */
    protected abstract function getCodeSeparator();

    public static function bootHasCode()
    {
        // before creating the model
        static::creating(function ($model) {
            /*if ( is_null($model->code) ) {
                $model->code = $model->generateCodeFromClassName();
            }*/
            self::setCodeIfNotExists($model);
        });
    }

    /**
     * Make sure the code field is given and set it if not
     * @param $code
     * @return string
     */
    public static function normalizeCodeField($code): string
    {
        return Str::slug(
            Str::lower($code),
            '-'
        );
    }

    public static function setCodeIfNotExists($model) {
        if ( is_null($model->code) ) {
            $model->code = $model->generateCodeFromClassName();
        }
    }

    public function generateCodeFromClassName(): string
    {
        $elem_type = str_replace("\\", $this->getCodeSeparator(), get_called_class());
        $elem_count = get_called_class()::all()->count();

        return self::normalizeCodeField( $elem_type . $this->getCodeSeparator() . $elem_count );
    }
}
