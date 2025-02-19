<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class TreatementAttempt
 * @package App\Models
 *
 * @property string $uuid
 * @property \Illuminate\Support\Carbon $date_debut
 * @property \Illuminate\Support\Carbon $date_fin
 * @property string $resultat
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class TreatementAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'date_debut',
        'date_fin',
        'resultat',
        'description',
    ];

    public static function defaultRules()
    {
        return [
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'resultat' => 'nullable|string',
            'description' => 'nullable|string|max:500',
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(), [
            'date_debut' => 'required|uuid|unique:treatement_attempts,date_debut',
            'resultat' => 'required|uuid|unique:treatement_attempts,resultat',
        ]);
    }
    public static function updateRules($id) {
        return array_merge(self::defaultRules(),
            [
                'date_debut' => ['required','unique:Sims,iccid,'.$id.',id',],
                'resultat' => ['required','unique:Sims,iccid,'.$id.',id',],
            ]
        );
    }

    public static function messagesRules()
    {
        return [
            'date_debut.required' => "Le champ date de début est obligatoire",
            'date_debut.date' => "Le champ date de début doit être une date valide",
            'resultat.required' => "Le champ date de début est obligatoire",
            'resultat.string' => "Le champ date de début doit être une date valide",

        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function request(): BelongsTo
    {
        return $this->belongsTo(RequestType::class);
    }

    public static function insertData(string $uuid, string $date_debut, string $date_fin, ?string $resultat, ?string $description)
    {
        self::create([
            'uuid' => $uuid,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'resultat' => $resultat,
            'description' => $description,
        ]);
    }
}
