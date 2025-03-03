<?php

namespace App\Models\Treatment;

use App\Models\User;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Events\TreatmentSucceedEvent;
use App\Models\SimRequest\SimRequest;
use App\Traits\Treatment\HasTreatment;
use App\Events\TreatmentDispatchedEvent;
use App\Contrats\Treatment\IHasTreatment;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
 * @property integer|null $treatment_result_id
 * @property integer|null $treatmentattempt_parent_id
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static TreatmentAttempt create(array $array)
 *
 * @property Treatment[] $treatments
 * @property Treatment $latesttreatment
 */
class TreatmentAttempt extends BaseModel implements IHasTreatment
{
    use HasFactory, HasTreatment;

    protected $guarded = [];

    public static $MAX_TREATMENT_FAILED_RETRY = 5;
    public static $MAX_TREATMENT_SUSPENDED_RETRY = 5;

    #region Validation Rules
    public static function defaultRules()
    {
        return [];
    }

    public static function createRules() {
        return array_merge(self::defaultRules(), []);
    }
    public static function updateRules($id) {
        return array_merge(self::defaultRules(), []);
    }

    public static function messagesRules()
    {
        return [];
    }
    #endregion

    #region Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * get Upper Treatment (SimRequest)
     * @return BelongsTo
     */
    public function uppertreatment()
    {
        return $this->belongsTo(SimRequest::class, "sim_request_id");
    }

    /**
     * @return HasMany
     */
    public function treatments()
    {
        return $this->hasMany(Treatment::class, "treatment_attempt_id");
    }

    public function latesttreatment()
    {
        return $this->hasOne(Treatment::class, 'treatment_attempt_id')->ofMany('id', 'max');
    }

    public function treatmentattemptparent()
    {
        return $this->belongsTo(TreatmentAttempt::class, "treatmentattempt_parent_id");
    }
    #endregion

    #region Treatment Status Management

    #endregion

    #region Insert & Update
    /**
     * @param SimRequest $simrequest
     * @param string $description
     * @return TreatmentAttempt
     */
    public static function insertData($simrequest, $description = "")
    {
        $new_treatmentattempt = self::create([
            'date_debut' => (New Carbon())->format('Y-m-d H:i:s'),
            'description' => $description,
        ]);

         //assignation de la simrequest
        $new_treatmentattempt->uppertreatment()->associate($simrequest)->save();

        //
        $new_treatmentattempt->setWaiting();

        return $new_treatmentattempt;
    }

    /**
     * @param SimRequest $simrequest
     * @param string $description
     * @return $this
     */
    public function updateOne($simrequest, $description = "")
    {
        $this->description = $description;

        if (!is_null($simrequest)) {
            $this->uppertreatment()->associate($simrequest);
        }
        $this->save();

        return $this;
    }

    /**
     * @param SimRequest $simrequest
     * @param string $description
     *
     * @return TreatmentAttempt
     */
    public static function updateOrNew($simrequest, $description = "")
    {
        $treatmentattempt = TreatmentAttempt::where('simrequest_id', $simrequest->id)->where('description', $description)->first();

        if ($treatmentattempt) {
            return $treatmentattempt->updateOne($simrequest, $description = "");
        } else {
            return TreatmentAttempt::insertData($simrequest, $description = "");
        }
    }
    #endregion

    /**
     * @return TreatmentAttempt[]|null
     */
    public static function getTreatmentsToBeExecuted()
    {
        return TreatmentAttempt::
            where('treatment_status_id', TreatmentStatus::getWaitingStatus()->id)
            ->OrWhere('treatment_status_id', TreatmentStatus::getFailedStatus()->id)
            ->OrWhere('treatment_status_id', TreatmentStatus::getSuspendedStatus()->id)
            ->get();
    }

    #region Excute Treatment

    public function executeAttempt()
    {
        if (count($this->treatments) === 0) {
            // Aucun traitement
            $this->getNextTreatment()->dispatchTreatment();

            return;
        }

        // -> si le dernier traitement est un success,
        if ($this->latesttreatment->isSuccess()) {
            $this->subTreatmentSucceed($this->latesttreatment);
            return;
        }

        // -> si le dernier est un echec,
        if ($this->latesttreatment->isFailed()) {
            $this->subTreatmentFailed($this->latesttreatment);
            return;
        }

        //si le dernier est en attente de traitement
        if ($this->isWaiting()) {
            //  -> lancer  a nouveau
            $this->latesttreatment->dispatchTreatment();
            $this->setWaiting();
            return;
        }

        // -> si le dernier  est  running
        if ($this->latesttreatment->isRunning()) {
            // -> ne pas intervenir  et sortir
            return;
        }

        // -> si le dernier est en suspension
        if ($this->latesttreatment->isSuspended()) {
            //-> re-tenter si le nombre max de tentatives est atteint
            if ($this->latesttreatment->treatmentresults()->count() >= self::$MAX_TREATMENT_SUSPENDED_RETRY) {
                //-> marquer la tentative comme Failed (Echec de la tentative)
                $this->setMaxSuspended();
                //
                $this->uppertreatment->setSuspended();
            } else {
                //-> sinon Reessayer a nouveau
                $this->latesttreatment->dispatchTreatment();
                $this->setWaiting();
            }
            return;
        }
    }

    /**
     * @param IHasTreatment $subtreatment
     */
    public function subTreatmentDispatched($subtreatment) {
        TreatmentDispatchedEvent::dispatch($this);
    }

    /**
     * @param IHasTreatment $subtreatment
     */
    public function subTreatmentFailed($subtreatment) {
        //-> re-tenter si le nombre max de tentatives est atteint
        if ($subtreatment->treatmentresults()->count() >= self::$MAX_TREATMENT_FAILED_RETRY) {
            // -> marquer la tentative comme Max-Failed (Echec de la tentative)
            $this->setMaxFailed();
            //marquer la requete comme failed
            $this->uppertreatment->subTreatmentFailed($this);
        } else {
            // -> sinon Reessayer a nouveau
            // $this->setWaiting();
            $subtreatment->dispatchTreatment();
        }
    }

    /**
     * @param IHasTreatment $subtreatment
     */
    public function subTreatmentSucceed($subtreatment) {
        // on passe au suivant
        $treatment = $this->getNextTreatment();
        // s'il n y a pas de traitement suivant,
        if (is_null($treatment)) {
            // marquer la tentative comme success
            $this->setSuccess();
            // et marquer la requete comme success
            TreatmentSucceedEvent::dispatch($this);
        } else {
            // sinon, on l'execute
            $treatment->dispatchTreatment();
            //$this->setWaiting();
        }
    }

    /**
     * @return Treatment
     */
    private function createNewExecBatch()
    {
        return $this->createNewTreatment(ExecBatchService::class, "Exec Batch Service", "Exec Batch Service");
    }
    private function createNewImportFile()
    {
        return $this->createNewTreatment(ImportFileService::class, "Import File Servie", "Import File Servie");
    }
    private function createSendResponse()
    {
        return $this->createNewTreatment(SendResponseService::class, "Send Response Service", "Send Response Service");
    }

    private function createNewTreatment($service_class, $libelle_service, $description) {
        $treatment = Treatment::insertData($service_class, $libelle_service, $description);
        $treatment->uppertreatment()->associate($this)->save();

        return $treatment;
    }

    /**
     * @param int $posi
     * @return Treatment|null
     */
    private function getNextTreatment($posi = -1)
    {
        if ( $posi === -1 ) {
            $posi = $this->treatments()->count() + 1;
        }

        switch ($posi) {
            case 1:
                return $this->createNewExecBatch();
                break;
            case 2:
                return $this->createNewImportFile();
                break;
            case 3:
                return $this->createSendResponse();
                break;
        }

        /*if ($this->latesttreatment->service_class === ExecBatchService::class) {
            return $this->createNewImportFile();
        } elseif ($this->latesttreatment->service_class === ImportFileService::class) {
            return $this->createSendResponse();
        }*/
        return null;
    }
    #endregion

}
