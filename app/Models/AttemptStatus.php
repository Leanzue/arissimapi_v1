<?php

namespace App\Models;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Concerns\TValue;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class attemptstatuses
 * @package App\Models
 *
 * @property string $nombre_essais
 * @property string $code
 * @property string $details
 * @property string $statut
 * @property string $comment
 * @property string $description
 *
 * @property TreatmentAttempt $treatmentattempts
 *
 * @method static create(string[] $array)
 *
 * @method static Builder running()
 * @method static Builder suspended()
 * @method static Builder ended()
 */
class AttemptStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'nombre_essais',
        'code',
        'details',
        'statut',
        'comment',
    ];

    public static function defaultRules() {
        return [
            'nombre_essais' => 'required|string',
            'details' => 'required|string',
            'statut' => 'required|string',
            'comment' => 'nullable|string',
        ];
    }

    public static function createRules() {
        return array_merge(self::defaultRules(),
            [
                'code' => ['required','unique:attempt_statuses,code,NULL,id',],
            ]
        );
    }

    public static function updateRules($id) {
        return array_merge(self::defaultRules(),
            [
                'code' => ['required','unique:attempt_statuses,code,'.$id.',id',],
            ]
        );
    }

    public static function messagesRules()
    {
        return [
            'nombre_essais.required' => "Le champs Nombre Essais est obligatoire",
            'nombre_essais.string' => "Le champs Nombre Essais doit etre une chaine de caracteres",
            'code.required' => "Le champs Nombre Essais doit etre une chaine de caracteres",
            'code.unique' => "Le champs Nombre Essais doit etre une chaine de caracteres",
        ];
    }

    #region Scopes

    public function scopeRunning($query) {
        return $query
            ->where('code', "running");
    }

    public function scopeSuspended($query) {
        return $query
            ->where('code', "suspended");
    }

    public function scopeEnded($query) {
        return $query
            ->where('code', "ended");
    }

    #endregion

    public function treatementattempts(): HasMany {
        return $this->hasMany(TreatmentAttempt::class);
    }

    public static function insertData(string $nombre_essais, string $error_code, string $details, string $statut, string $comment)
    {
        self::create([
            'nombre_essais' => $nombre_essais,
            'error_code' => $error_code,
            'details' => $details,
            'statut' => $statut,
            'comment' => $comment,
        ]);
    }

    /**
     * @return AttemptStatus|TValue|null
     */
    public static function getRunningStatus() {
        return self::running()->first();
    }

    /**
     * @return AttemptStatus|TValue|null
     */
    public static function getSuspendedStatus() {
        return self::suspended()->first();
    }
    /**
     * @return AttemptStatus|TValue|null
     */
    public static function getendedStatus() {
        return self::ended()->first();
    }
    public function updateOne(string $nombre_essais,string $details,$statut, string $code, string $description = null): static
    {
        $this->nombre_essais = $nombre_essais;
        $this->code = $code;
        if ( ! is_null($description) ) {
            $this->description = $description;
        }

        $this->save();

        return $this;
    }

    public static function updateOrNew(string $nombre_essais,string $details,$statut, string $code, string $description = null)
    {
        $status = AttemptStatus::where('code', $code)->first();

        if ($status) {
            return $status->updateOne( $nombre_essais,$details,$statut, $code,$description );
        } else {
            return AttemptStatus::insertData($nombre_essais,$details,$statut, $code,$description );
        }
    }
    #endregion

}
