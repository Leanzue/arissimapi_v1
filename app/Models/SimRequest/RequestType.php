<?php

namespace App\Models\SimRequest;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 *class requestTypes
 * @package App\Models
 *
 * @property string $code
 * @property string $libelle
 * @property string $description
 *
 * @property SimRequest $simrequests
 *
 * @method static create(array $array)
 */
class RequestType extends BaseModel
{
    /** @use HasFactory<\Database\Factories\RequestTypeFactory> */
    use HasFactory;

    protected $guarded = [];

    #validation rules

    public static function defaultRules()
    {
        return [
            'code' => 'required|string',
            'libelle' => 'required|string',
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(),
            [
                'code' => ['required','unique:request_types,code,NULL,id',],
            ]
        );
    }
    public static function updateRules($id) {
        return array_merge(self::defaultRules(),
            [
                'code' => ['required', 'unique:request_types,code,'.$id.',id'],
            ]
        );

    }
    public static function messagesRules()
    {
        return [

            'code.required' => "Le champs code obligatoire",
            'code.unique' => "Le code doit etre unique",
            'code.string' => "Le champs  code doit etre une chaine de caracteres",
            'libelle.required' => "Le champs libelle obligatoire",
            'libelle.string' => "Le champs libelle doit etre une chaine de caracteres",
        ];
    }
    #end validation




    # region relationship
    /**
     * @return HasMany
     */
    public function simrequests()
    {
        return $this->hasMany(SimRequest::class);
    }
    #end relationship

    #region Insert & Update

    /**
     * @param string $code
     * @param string $libelle
     * @param string $description
     * @return RequestType|null
     */
    public static function insertData($code, $libelle, $description = "")
    {
        return self::create([
            'code' => $code,
            'libelle' => $libelle,
            'description' => $description,
        ]);
    }

    /**
     * @param string $code
     * @param string $libelle
     * @param string $description
     * @return $this
     */
    public function updateOne($code, $libelle, $description = "")
    {
        $this->code = $code;
        $this->libelle = $libelle;
        $this->description = $description;

        $this->save();

        return $this;
    }

    public static function updateOrNew($code, $libelle, $description = "")
    {
        $requesttype =  RequestType::where('code',$code)->first();

        if ($requesttype) {
            return $requesttype->updateOne($code, $libelle, $description);
        } else {
            return  RequestType::insertData($code, $libelle, $description);
        }
    }
    #endregion
}

