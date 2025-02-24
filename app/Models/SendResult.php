<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * Class sendresults
 * @package App\Models
 *
 * @property string $result_description
 * @property string $nombre_tentative
 * @property string $date_envoi
 * @property string $error_code
 *
 * @property AttemptResult $attemptresults
 * @method static create(array $array)
 * @method static updateOrNew(string $string, string $string1, string $string2, string $string3)
 */
class SendResult extends baseModel
{
    /** @use HasFactory<\Database\Factories\SendResultFactory> */
    use HasFactory;

    protected $fillable = [
        'uuid',
        'result_description',
        'nombre_tentative',
        'date_envoi',
        'error_code',
    ];

    public static function defaultRules()
    {
        return [
            'result_description' => 'required|string',
            'nombre_tentative' => 'required|string',
            'date_envoi' => 'required|string',
            'error_code' => 'required|string',
        ];
    }
    public static function createRules()
    {
        return array_merge(self::defaultRules(),
            [
                'nombre_tentative' => ['required', 'unique:send_results,nombre_tentative,NULL,id',],
                'date_envoi' => ['required', 'unique:send_results,date_envoi,NULL,id',],
                'error_code' => ['required', 'unique:send_results,error_code,NULL,id',],

            ]
        );
    }
    public static function updateRules($id) {
        return array_merge(self::defaultRules(),
            [
                'nombre_tentative' => ['required','unique:SendResults,nombre_tentative,'.$id.',id',],
                'date_envoi' => ['required','unique:Send_Results,date_envoi,'.$id.',id',],
                'error_code' => ['required','unique:Send_Results,error_code,'.$id.',id',],
            ]
        );
    }
    public static function messagesRules()
    {
        return [
            'nombre_tentative.required' => "Le champs nombre_tentative_results obligatoire",
            'nombre_tentative.string' => "Le champs nombre_tentative_results doit etre une chaine de caracteres",
            'date_envoi.required' => "Le champs  date_envoi obligatoire",
            'date_envoi.string' => "Le champs  date_envoi doit etre une chaine de caracteres",
            'error_code.required' => "Le champs  error_code obligatoire",
            'error_code.string' => "Le champs  error_code doit etre une chaine de caracteres",
        ];

    }

    public function AttemptResult(): BelongsTo
    {
        return $this->belongsTo(AttemptResult::class, 'AttemptResult_id');
    }
    public static function insertData(string $result_description, string $nombre_tentative, string $date_envoi, string $error_code)
    {
        self::create([
            'result_description' => $result_description,
            'nombre_tentative' => $nombre_tentative,
            'date_envoi' => $date_envoi,
            'error_code' => $error_code,
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
