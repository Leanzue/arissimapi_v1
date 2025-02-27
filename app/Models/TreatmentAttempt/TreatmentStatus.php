<?php

namespace App\Models\TreatmentAttempt;

use App\Models\BaseModel;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Concerns\TValue;
use App\Traits\TreatmentAttempt\HasTreatment;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;



/**
 * Class attemptstatuses
 * @package App\Models
 *
 * @property string $code
 * @property string $libelle
 * @property string $description
 *
 * @property TreatmentAttempt $treatmentattempts
 *
 * @method static create(string[] $array)
 *
 * @method static Builder waiting()
 * @method static Builder running()
 * @method static Builder suspended()
 * @method static Builder ended()
 * @method static Builder success()
 * @method static Builder failed()
 */


class TreatmentStatus extends BaseModel
{
    use HasFactory,HasTreatment;

    protected $guarded = [];

    public static function defaultRules() {
        return [
            'libelle' => 'required|string',
            'description' => 'required|string',
        ];
    }

    public static function createRules() {
        return array_merge(self::defaultRules(),
            [
                'code' => ['required','unique:Treatment_Status,code,NULL,id',],
            ]
        );
    }

    public static function updateRules($id) {
        return array_merge(self::defaultRules(),
            [
                'code' => ['required','unique:Treatment_Status,code,'.$id.',id',],
            ]
        );
    }

    public static function messagesRules()
    {
        return [
            'libelle.required' => "Le champs libelle doit etre une chaine de caracteres",
            'libelle.unique' => "Le champs libelle doit etre une chaine de caracteres",
            'code.required' => "Le champs code  doit etre une chaine de caracteres",
            'code.unique' => "Le champs code doit etre une chaine de caracteres",
        ];
    }

    #region Scopes

    public function scopeWaiting($query) {
        return $query
            ->where('code', "waiting");
    }

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

    public function scopeSuccess($query) {
        return $query
            ->where('code', "success");
    }

    public function scopeFailed($query) {
        return $query
            ->where('code', "failed");
    }

    /**
     * @return TreatmentStatus|TValue|null
     */
    public static function getWaitingStatus() {
        return TreatmentStatus::waiting()->first();
    }

    /**
     * @return TreatmentStatus|TValue|null
     */
    public static function getRunningStatus() {
        return TreatmentStatus::running()->first();
    }

    /**
     * @return TreatmentStatus|TValue|null
     */
    public static function getSuspendedStatus() {
        return TreatmentStatus::suspended()->first();
    }
    /**
     * @return TreatmentStatus|TValue|null
     */
    public static function getEndedStatus()
    {
        return TreatmentStatus::ended()->first();
    }

    /**
     * @return TreatmentStatus|TValue|null
     */
    public static function getSuccessStatus()
    {
        return TreatmentStatus::success()->first();
    }

    /**
     * @return TreatmentStatus|TValue|null
     */
    public static function getFailedStatus()
    {
        return TreatmentStatus::failed()->first();
    }
    #endregion

    #region relationship
    /**
     * @return HasMany
     */
    public function treatementattempts() {
        return $this->hasMany(TreatmentAttempt::class);
    }
  #endregion

    #region Insert & Update
    public static function insertData( $code,  $libelle,  $description = null)
    {
        self::create([
            'code' => $code,
            'libelle' => $libelle,
            'description' => $description,
        ]);
    }

    /**
     * @param string $code
     * @param string $libelle
     * @param string $description
     *
     * @return $this
     */
    public function updateOne( $code,  $libelle,  $description = null)
    {
        $this->code = $code;
        $this->$libelle = $libelle;
        $this->description = $description;

        $this->save();

        return $this;
    }

    /**
     * @param string $code
     * @param string $libelle
     * @param string|null $description
     */
    public static function updateOrNew( $code,  $libelle,  $description = null)
    {
        $status = TreatmentStatus::where('code', $code)->first();

        if ($status) {
            return $status->updateOne($code, $libelle, $description);
        } else {
            return TreatmentStatus::insertData($code, $libelle, $description);
        }
    }
    #endregion

}
