<?php

namespace App\Models\SimRequest;

use App\Models\BaseModel;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class requeststatuses
 * @package App\Models
 *
 * @property string $priority
 * @property string $libelle
 * @property string $code
 * @property string $description
 *
 * @property SimRequest $simrequests
 * @method static create(array $validatedData)
 *
 * @method static QueryBuilder waiting()
 * @method static QueryBuilder running()
 * @method static QueryBuilder suspended()
 * @method static QueryBuilder ended()
 */
class RequestStatus extends BaseModel
{
    use HasFactory;

    protected $guarded = [];

    #region Validation Rules
    public static function defaultRules()
    {
        return [
            'priority' => 'required|string',
            'libellé' => 'required|string',
            'code'=>'required|string',
        ];
    }
    public static function createRules()
    {
        return array_merge(self::defaultRules(),
            [
                'priority' => ['required', 'unique:request_statuses,priority,null,id',],
                'code ' => ['required', 'unique:request_statuses,code,null,id',],

            ]
        );

    }
    public static function updateRules($id) {
        return array_merge(self::defaultRules(),
            [
                'priority' => ['required','unique:request_statuses,priority,'.$id.',id',],
                'code' => ['required','unique:request_statuses,code,'.$id.',id',],
            ]
        );
    }

    public static function messagesRules()
    {
        return [
            'priority.required' => "Le champs priority est obligatoire",
            'priority.string' => "Le champs  priority doit etre une chaine de caracteres",
            'code.required' => "Le champs  code doit etre une chaine de caracteres",
            'code.string' => "Le champs  code doit etre une chaine de caracteres",
        ];
    }
    #endregion

    #region scopes & related functions
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

    /**
     * @return RequestStatus|TValue|null
     */
    public static function getWaitingStatus() {
        return RequestStatus::waiting()->first();
    }

    /**
     * @return RequestStatus|TValue|null
     */
    public static function getRunningStatus() {
        return RequestStatus::running()->first();
    }

    /**
     * @return RequestStatus|TValue|null
     */
    public static function getSuspendedStatus() {
        return RequestStatus::suspended()->first();
    }
    /**
     * @return RequestStatus|TValue|null
     */
    public static function getEndedStatus()
    {
        return RequestStatus::ended()->first();
    }
    #endregion

    #region Relationships
    /**
     * @return HasMany
     */
    public function SimRequests()
    {
        return $this->hasMany(SimRequest::class);
    }
    #endregion

    #region MAIN Insert/Update

    /**
     * @param string $code
     * @param string $libelle
     * @param int $priority
     * @param string $description
     */
    public static function insertData($code, $libelle , $priority = 0, $description = "")
    {
        self::create([
            'priority' => $priority,
            'libelle' => $libelle,
            'code' => $code,
            'description' => $description,

        ]);
    }

    /**
     * @param string $code
     * @param string $libelle
     * @param int $priority
     * @param string $description
     * @return $this
     */
    public function updateOne($code, $libelle , $priority, $description = "")
    {
        $this->code = $code;
        $this->libelle = $libelle;
        $this->priority = $priority;
        $this->description = $description;

        $this->save();

        return $this;
    }

    /**
     * @param string $code
     * @param string $libelle
     * @param int $priority
     * @param string $description
     */
    public static function updateOrNew($code, $libelle , $priority, $description = "")
    {
        $requeststatus = RequestStatus::where('code', $code)->first();

        if ($requeststatus) {
            return $requeststatus->updateOne($code, $libelle, $priority, $description);
        } else {
            return RequestStatus::insertData($code, $libelle, $priority, $description);
        }
    }
    #endregion

}
