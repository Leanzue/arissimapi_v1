<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class sendattempts
 * @package App\Models
 *
 * @property string $response_data
 * @property datetime $response_time
 *
 * @property SendAttempt $sendattempts
 * @method static create(array $array)
 * @method static updateOrNew(string $string, string $string1)
 */

class SendAttempt extends BaseModel
{
    /** @use HasFactory<\Database\Factories\SendAttemptFactory> */
    use HasFactory;
    protected $fillable = [
        'uuid',
        'response_data',
        'response_time',
    ];

    public static function defaultRules()
    {
        return [
            'response_data' => 'required|string',
            'response_time' => 'required|datetime',
        ];
    }
    public static function createRules()
    {
        return array_merge(self::defaultRules(),
            [
                'response_time' => ['required', 'unique:send_attempts,response_time,Null,id',],
            ]
        );
    }
    public static function updateRules($id) {
        return array_merge(self::defaultRules(),
            [
                'response_time' => ['required','unique:send_Attempt,response_time,'.$id.',id',],
            ]
        );
    }
    public static function messagesRules()
    {
        return [
            'response_time.required' => "Le champs  response_time obligatoire",
            'response_time.datetime' => "Le champs  response_time doit etre une chaine de caracteres",
        ];
    }

    public function SendAttemptResult(): BelongsTo
    {
        return $this->belongsTo(SendAttemptResult::class, 'SendAttemptResult_id');
    }
    public function SendStatus(): BelongsTo
    {
        return $this->belongsTo(SendStatus::class, 'SendStatus_id');
    }
    public static function insertData(string $response_data, datetime $response_time)
    {
        self::create([
            'response_data' => $response_data,
            'response_time' => $response_time  ,
        ]);
    }
    #region Insert & Modif Model
    public static function insertData($response_data, string $response_time = null)
    {
        self::create([
            'response_data' => $response_data,
            'response_time' => $response_time,
        ]);
    }

    public function updateOne(string $response_data, string $response_time = null): static
    {
        $this->response_data = $response_data;
        $this->response_time = $response_time;
        if ( ! is_null($response_data) ) {
            $this->response_data = $response_data;
        }

        $this->save();

        return $this;
    }

    public static function updateOrNew(string $response_data, string $response_time = null)
    {
        $status = SendAttempt::where('code', $code)->first();

        if ($status) {
            return $status->updateOne($response_data,$response_time);
        } else {
            return SendAttempt::insertData($response_data,$response_time);;
        }
    }
    #endregion



}
