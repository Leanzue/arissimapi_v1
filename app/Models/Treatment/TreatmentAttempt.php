<?php

namespace App\Models\Treatment;

use App\Models\User;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\SimRequest\SimRequest;
use App\Traits\Treatment\HasTreatment;
use App\Contrats\Treatment\IHasTreatment;
use App\Events\TreatmentStatusChangedEvent;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class TreatmentAttempt
 * @package App\Models
 *
 * @property int $id
 * @property string $uuid
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
     * retourne les traitements de la tentative|la relation eloquent
     * @return HasMany
     */
    public function treatments()
    {
        return $this->hasMany(Treatment::class, "treatment_attempt_id");
    }

    /**
     * retourne le dernier traitement de la tentative|la relation eloquent
     * @return HasOne
     */
    public function latesttreatment()
    {
        return $this->hasOne(Treatment::class, 'treatment_attempt_id')->ofMany('id', 'max');
    }
    #endregion

    #region Insert & Update
    /**
     * insert un nouvel objet TreatmentAttempt dans la base de données
     * @param SimRequest $simrequest
     * @param string $description
     * @return TreatmentAttempt
     */
    public static function insertData($simrequest, $description = "")
    {
        $new_treatmentattempt = self::create([
            'description' => $description,
        ]);

         //assignation de la simrequest
        $new_treatmentattempt->uppertreatment()->associate($simrequest)->save();

        //
        $new_treatmentattempt->setWaiting();

        return $new_treatmentattempt;
    }

    /**
     * Modifie un objet TreatmentAttempt à partir de la base de données
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
     * Modifie ou insert un objet TreatmentAttempt dans la base de données
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

    #region Excute Treatment
    /**
     * retourne les tentatives qui peuvent etre exécutés
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

    public function executeAttempt()
    {
        if (count($this->treatments) === 0) {
            // Aucun traitement
            $this->getNextTreatment()->dispatchTreatment();

            // Creéer le Resultat de la Tentative
            $this->startTreatment("Exécution Tentative (" . $this->id . ") - Requête (" . $this->uppertreatment->id . ")");

            return;
        }

        //si le dernier est en attente de traitement
        if ($this->isWaiting()) {
            //  -> lancer  a nouveau
            $this->latesttreatment->dispatchTreatment();
            return;
        }

        // -> si le dernier traitement est un success,
        if ($this->latesttreatment->isSuccess()) {
            $this->subTreatmentStatusChanged($this->latesttreatment);
            return;
        }

        // -> si le dernier est un echec,
        if ($this->latesttreatment->isFailed()) {
            $this->subTreatmentStatusChanged($this->latesttreatment);
            return;
        }

        // -> si le dernier est en suspension
        if ($this->latesttreatment->isSuspended()) {
            $this->subTreatmentStatusChanged($this->latesttreatment);
            return;
        }

        // -> si le dernier  est  running
        if ($this->latesttreatment->isRunning()) {
            // -> ne pas intervenir  et sortir
            return;
        }
    }

    /**
     * crée un nouveau traitement d'exécution de Batch
     * @return Treatment
     */
    private function createNewExecBatch()
    {
        return $this->createNewTreatment(ExecBatchService::class, "Exec Batch Service", "Exec Batch Service");
    }

    /**
     * crée un nouveau traitement d'importation/parse de fichier reponse
     * @return Treatment
     */
    private function createNewImportFile()
    {
        return $this->createNewTreatment(ImportFileService::class, "Import File Servie", "Import File Servie");
    }

    /**
     * crée un nouveau traitement d'envoi de reponse
     * @return Treatment
     */
    private function createSendResponse()
    {
        return $this->createNewTreatment(SendResponseService::class, "Send Response Service", "Send Response Service");
    }

    /**
     * crée et attache un nouveau traitement pour la tentative
     * @param $service_class
     * @param $libelle_service
     * @param $description
     * @return Treatment
     */
    private function createNewTreatment($service_class, $libelle_service, $description) {
        $treatment = Treatment::insertData($service_class, $libelle_service, $description);
        $treatment->uppertreatment()->associate($this)->save();

        return $treatment;
    }

    /**
     * retourne le prochain traitement de la tentative
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
        return null;
    }
    #endregion

    #region Treatment Status Management
    /**
     * @param IHasTreatment|Treatment $subtreatment
     */
    public function subTreatmentStatusChanged($subtreatment)
    {
        if ( $subtreatment->isWaiting() ) {
            $this->setWaiting();
            TreatmentStatusChangedEvent::dispatch($this);
        } elseif ( $subtreatment->isQueueing() ) {
            $this->setQueueing();
            TreatmentStatusChangedEvent::dispatch($this);
        } elseif ( $subtreatment->isRunning() ) {
            $this->setRunning();
            TreatmentStatusChangedEvent::dispatch($this);
        } elseif ( $subtreatment->isSuccess() ) {
            $this->subTreatmentSucceed($subtreatment);
        } elseif ( $subtreatment->isFailed() ) {
            $this->subTreatmentFailed($subtreatment);
        } elseif ($subtreatment->isMaxFailed() ) {
            $this->subTreatmentFailed($subtreatment);
        } elseif ($subtreatment->isSuspended() ) {
            $this->subTreatmentSuspended($subtreatment);
        } elseif ($subtreatment->isMaxSuspended() ) {
            $this->subTreatmentSuspended($subtreatment);
        }
    }

    /**
     * @param IHasTreatment|Treatment $subtreatment
     */
    private function subTreatmentFailed($subtreatment) {
        //-> re-tenter si le nombre max de tentatives est atteint
        if ($subtreatment->treatmentresults()->count() >= self::$MAX_TREATMENT_FAILED_RETRY) {
            // -> marquer la tentative comme Max-Failed (Echec de la tentative)
            $this->setMaxFailed();
            // et dispatcher le changement de statut
            TreatmentStatusChangedEvent::dispatch($this);

            $this->subtreatmentEndWithFailure($subtreatment);
        } else {
            // -> sinon Reessayer a nouveau
            $this->setWaiting();
            // et dispatcher le changement de statut
            TreatmentStatusChangedEvent::dispatch($this);
        }
    }

    /**
     * @param IHasTreatment|Treatment $subtreatment
     */
    public function subTreatmentSuspended($subtreatment) {
        //-> re-tenter si le nombre max de tentatives est atteint
        if ($subtreatment->treatmentresults()->count() >= self::$MAX_TREATMENT_SUSPENDED_RETRY) {
            //-> marquer la tentative comme Failed (Echec de la tentative)
            $this->setMaxSuspended();
            // et dispatcher le changement de statut
            TreatmentStatusChangedEvent::dispatch($this);
            $this->subtreatmentEndWithFailure($subtreatment);
        } else {
            //-> sinon Reessayer a nouveau
            $subtreatment->dispatchTreatment();
        }
    }

    /**
     * @param IHasTreatment|Treatment $subtreatment
     */
    private function subTreatmentSucceed($subtreatment) {
        // on passe au suivant
        Log::info("TreatmentAttempt - subTreatmentSucceed (" . $subtreatment->id . "). service: " . $subtreatment->service_class);
        $treatment = $this->getNextTreatment();
        // s'il n y a pas de traitement suivant,
        if (is_null($treatment)) {
            // marquer la tentative comme success
            $this->setSuccess();
            // et dispatcher le changement de statut
            TreatmentStatusChangedEvent::dispatch($this);

            // fin de la tentative de traitement
            $this->endTreatmentWithSuccess();
        } else {
            // sinon, on l'execute
            $treatment->dispatchTreatment();
        }
    }

    /**
     * @param IHasTreatment|Treatment $subtreatment
     */
    private function subtreatmentEndWithFailure($subtreatment) {
        // fin de la tentative de traitement
        $this->endTreatmentWithFailure("Echec Traitement " . $subtreatment->service_class . " (" . $subtreatment->id . ")");
    }
    #endregion
}
