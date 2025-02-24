<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
*class requestTypes
* @package App\Models
*
* @property string $action
* @property string $libellé
*
* @property SimRequest $simrequests
 * @method static create(array $array)
 * @method static updateOrNew(string $string, string $string1, string $string2, string $string3)
 */
class RequestType extends BaseModel
{
    /** @use HasFactory<\Database\Factories\RequestTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'uuid',
        'action',
        'libellé',

        ];



    public static function defaultRules()
    {
        return [
            'action' => 'required|string',
            'libellé' => 'required|string',
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(),
            [
                'action' => ['required','unique:requestType,action,NULL,id',],
            ]
        );
    }
    public static function updateRules($id) {
        return array_merge(self::defaultRules(),
            [
                'action' => ['required', 'unique:request_types,action,'.$id.',id'],
            ]
        );

    }
    public static function messagesRules()
    {
        return [
            'action.required' => "Le champs  action obligatoire",
            'action.string' => "Le champs  action doit etre une chaine de caracteres",
        ];
    }
    public function SimRequests(): HasMany
    {
        return $this->hasMany(SimRequest::class);
    }
    public static function insertData(string $action, string $libellé)
    {
        self::create([
            'action' => $action,
            'libellé' => $libellé,

        ]);
    }
    #region Insert & Modif Model
    public static function insertData($name, string $code, string $style, string $is_default,string $description  = null)
    {
        self::create([
            'name' => $name,
            'code' => $code,
            'style' => $style,
            'is_default' => $is_default,
            'description' => $description,
        ]);
    }

    public function updateOne($name, string $code, string $style, string $is_default,string $description  = null): static
    {
        $this->name = $name;
        $this->style = $style;
        $this->code = $code;
        $this->is_default = $is_default;
        if ( ! is_null($description) ) {
            $this->description = $description;
        }

        $this->save();

        return $this;
    }

    public static function updateOrNew($name, string $code, string $style, string $is_default,string $description  = null)
    {
        $status = SendStatus::where('code', $code)->first();

        if ($status) {
            return $status->updateOne($name,$code,$style,$is_default, $description);
        } else {
            return SendStatus::insertData($name,$code,$style,$is_default, $description);
        }
    }
    #endregion



}

