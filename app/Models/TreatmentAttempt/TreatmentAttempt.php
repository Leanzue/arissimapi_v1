<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use function Carbon\this;

/**
 * Class TreatmentAttempt
 * @package App\Models
 *
 * @property string $uuid
 *
 * @property Carbon $date_debut
 * @property Carbon $date_fin
 * @property string $description
 *
 * @property integer|null $attempt_status_id
 * @property integer|null $user_id
 * @property integer|null $sim_request_id
 * @property integer|null $attempt_result_id
 * @property integer|null $treatmentattempt_parent_id
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static updateOrNew(string $string, string $string1, string $string2, string $string3, string $string4)
 */
class TreatmentAttempt extends BaseModel
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
                'date_debut' => ['required','unique:treatement_attempts,'.$id.',id',],
                'resultat' => ['required','unique:treatement_attempts,'.$id.',id',],
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

    public function attemptstatus(): BelongsTo
    {
        return $this->belongsTo(AttemptStatus::class, "attempt_status_id");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function simrequest(): BelongsTo
    {
        return $this->belongsTo(SimRequest::class, "sim_request_id");
    }

    public function treatmentattemptparent(): BelongsTo
    {
        return $this->belongsTo(TreatmentAttempt::class, "treatmentattempt_parent_id");
    }

    public function setStart() {
        $this->date_debut = (New Carbon())->format('Y-m-d H:i:s');
        $this->save();
    }

    public function setRunning() {
        $running_status = AttemptStatus::getRunningStatus();
        if ($running_status) {
            $this->attemptstatus()->associate($running_status)->save();
        } else {
            Log::error("Attempt running status not found");
        }
    }

    public function setEnd() {
        $this->date_fin = (New Carbon())->format('Y-m-d H:i:s');
        $this->save();
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
