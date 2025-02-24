<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class sendattemptresults
 * @package App\Models
 *
 * @property string $date_of_sending_result
 * @property string $details
 * @property string $error_code
 * @property string $nombre_de_tentative
 *
 * @property SendAttempt $sendattempts
 * @method static updateOrNew(string $string, string $string1, string $string2, string $string3)
 * @method static create(array $entry)
 */
class SendAttemptResult extends BaseModel

{
    /** @use HasFactory<\Database\Factories\SimFactory> */
    use HasFactory;
    protected $fillable = [
        'uuid',
        'date_of_sending_results',
        'details',
        'error_code',
        'nombre_de_tentative',


    ];


    public static function defaultRules()
    {
        return [
            'date_of_sending_results' => 'required|string',
            'details' => 'required|string',
            'error_code' => 'required|string',
            'nombre_de_tentative' => 'required|string',
        ];
    }
    public static function createRules()
    {
        return array_merge(self::defaultRules(),
            [
                'date_of_sending_result' => [
                    'required',
                    'unique:send_attempt_results,date_of_sending_result,NULL,id',
                    ],
                'error_code' => ['required', 'unique:send_attempt_results,error_code,NULL,id',],
                'nombre_de_tentative' => ['required', 'unique:send_attempt_results,nombre_de_tentative,NULL,id',],
            ]
        );
    }
    public static function updateRules($id) {
        return array_merge(self::defaultRules(),
            [
                'date_of_sending_result' => ['required','unique:send_attempt_results,response_time,'.$id.',id',],
                'error_code' => ['required','unique:send_attempt_results,response_time,'.$id.',id',],
                'nombre_de_tentative' => ['required','unique:send_attempt_results,response_time,'.$id.',id',],
            ]
        );
    }
    public static function messagesRules()
    {
        return [
            'date_of_sending_results.required' => "Le champs  date_of_sending_results obligatoire",
            'date_of_sending_results.string' => "Le champs  date_of_sending_results doit etre une chaine de caracteres",
            'error_code.required' => "Le champs  error_code obligatoire",
            'error_code.string' => "Le champs  error_code doit etre une chaine de caracteres",
            'nombre_de_tentative.required' => "Le champs  response_time obligatoire",
            'nombre_de_tentative.string' => "Le champs  response_time doit etre une chaine de caracteres",
            ];

    }

    public function SendAttempts(): HasMany {
        return $this->hasMany(SendAttempt::class);
    }

    public static function insertData(string $date_of_sending_results, string $details, string $error_code, string $nombre_de_tentative )
    {
        self::create([
            'date_of_sending_results' => $date_of_sending_results,
            'details' => $details,
            'error_code' => $error_code,
            'nombre_de_tentative' => $nombre_de_tentative,
        ]);
    }
    #region Insert & Modif Model
    public static function insertData($date_of_sending_results, string $code, string $style, string $is_default,string $description  = null)
    {
        self::create([
            'details' => $details,
            'error_code' => $error_code,
            'nombre_de_tentative' => $nombre_de_tentative,

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
