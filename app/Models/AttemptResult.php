<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class attemptresults
 * @package App\Models
 *
 * @property string $date_tentative
 * @property string $details
 * @property string $resultat
 * @property string $comment
 *
 * @property SendResult $sendresults
 * @method static create(string[] $entry)
 * @method static updateOrNew(string $string, string $string1, string $string2, string $string3)
 */
class AttemptResult extends baseModel
{
    /** @use HasFactory<\Database\Factories\AttemptResultFactory> */
    use HasFactory;
    protected $fillable = [
        'uuid',
        'date_tentative',
        'details',
        'resultat',
        'comment',
    ];
    public static function defaultRules()
    {
        return [
            'date_tentative' => 'required|string',
            'details' => 'required|string',
            'resultat' => 'required|string',
            'comment' => 'required|string',
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(),
            [
                'date_tentative' => ['required','unique:TreatmentAttempt,date_debut,NULL,id',],
                'resultat' => ['required','unique:TreatmentAttempt,resultat,NULL,id',],
            ]
        );
    }
    public static function updateRules($id) {
        return array_merge(self::defaultRules(),
            [
                'date_tentative' => ['required','unique:TreatementAttempts,date_debut,'.$id.',id',],
                'resultat' => ['required','unique:TreatementAttempts,resultat,'.$id.',id',],
            ]
        );
    }

    public static function messagesRules()
    {
        return [
            'date_tentative.required' => "Le champs date_debutest obligatoire",
            'date_tentative.string' => "Le champs date_debut est obligatoire",
            'resultat.required' => "Le champs code est obligatoire",
            'resultat.string' => "Le champs  resultat doit etre une chaine de caracteres",
        ];
    }


    public function SendResult(): HasMany
    {
        return $this->hasMany(SendResult::class);
    }
    public static function insertData(string $date_tentative, string $details, string $resultat, string $comment)
    {
        self::create([
            'date_tentative' => $date_tentative,
            'details' => $details,
            'resultat' => $resultat,
            'comment' => $comment,
        ]);
     }
    #region Insert & Modif Model
    public static function insertData($date_tentative, string $details, string $resultat, string $comment  = null)
    {
        self::create([
            'date_tentative' => $date_tentative,
            'details' => $details,
            'resultat' => $resultat,
            'comment' => $comment,
        ]);
    }

    public function updateOne($date_tentative, string $details, string $resultat, string $comment  = null): static
    {
        $this->date_tentative=$date_tentative;
         $this->details= $details;
           $this-> resultat= $resultat;
           $this-> comment = $comment;
        if ( ! is_null($comment) ) {
            $this->comment = $comment;
        }

        $this->save();

        return $this;
    }

    public static function updateOrNew($date_tentative, string $details, string $resultat, string $comment  = null)
    {
        $AttemptResult = AttemptResult::where('code', $code)->first();

        if ($AttemptResult) {
            return $AttemptResult->updateOne($date_tentative,$details,$resultat,$comment);
        } else {
            return AttemptResult::insertData($date_tentative,$details,$resultat,$comment);
        }
    }
    #endregion

}

}

