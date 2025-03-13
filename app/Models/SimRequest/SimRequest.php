<?php

namespace App\Models\SimRequest;

use App\Models\Sim\Sim;
use App\Models\BaseModel;
use Illuminate\Support\Str;
use App\Traits\Code\HasCode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Traits\Treatment\HasTreatment;
use App\Models\Treatment\TreatmentStatus;
use App\Contrats\Treatment\IHasTreatment;
use App\Models\Treatment\TreatmentAttempt;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Requests\SimRequest\StoreSimRequestRequest;


/**
 *class simrequests
 * @package App\Models
 *
 * @property int $id
 * @property string $code
 * @property string $client_ip_address
 * @property string $url_response
 * @property string $description
 *
 * @property integer|null $treatment_status_id
 * @property integer|null $request_type_id
 *
 * @property string|null $file_prefix
 * @property string|null $file_extension
 * @property string|null $client_key_request
 *
 * @property RequestType $requestTypes
 * @property Sim $sim
 * @property-read string|null $response_file_name
 *
 * @method static SimRequest create(string[] $array)
 * @method static SimRequest|null find(int $id)
 * @property SimRequestResponseFile $latestresponsefile
 * @property TreatmentAttempt[] $treatmentattempts
 * @property TreatmentAttempt $latesttreatmentattempt
 *
 * @property bool $is_batch_response_file_exists
 */

class SimRequest extends BaseModel implements IHasTreatment
{
    public static $REQRESPONSE_FOLDER_CONFIG_DIR = "reqresponse_folder";
    public static $REQRESPONSE_FILE_KEY= "_res";
    pUBLIC static $MAX_ATTEMPTS_FAILED_RETRY = 5 ;
    pUBLIC static $MAX_ATTEMPTS_SUSPENDED_RETRY = 5 ;
    pUBLIC static $FILE_EXTENSION = "csv" ;


    /** @use HasFactory<\Database\Factories\SimRequestFactory> */
    use HasFactory, HasTreatment;

    protected $guarded = [];
    protected $with = ['sim'];


    #region validation Rules
    public static function defaultRules()
    {
        return [
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(),
            [
                'iccid' => 'required|string',
                'url_response' => 'required|string',
            ]
        );
    }

    public static function updateRules($model)
    {
        return array_merge(self::defaultRules(), []
        );
    }

    public static function messagesRules()
    {
        return [
            'iccid.required' => "Le champs iccid est obligatoire",
            'url_response.required' => "Le champs url_response est obligatoire",
        ];
    }
    #endregion validation rules

    #region Attributors
    public function getResponseFileNameAttribute()
    {
        $separator = "\\";
        if (is_null($this->file_prefix)) {
            Log::error("File prefix not set for request (" . $this->id . ")") ;
            return null;
        }
        if (is_null($this->file_extension)) {
            Log::error("File extension not set for request (" . $this->id . ")") ;
            return null;
        }

        $folder = config('app.' . self::$REQRESPONSE_FOLDER_CONFIG_DIR);
        $filename = $this->file_prefix . self::$REQRESPONSE_FILE_KEY . "." . $this->file_extension;

        return base_path($folder) . DIRECTORY_SEPARATOR . $filename;
    }

    /**
     * @return bool
     */
    public function getIsBatchResponseFileExistsAttribute()
    {
        return File::exists($this->response_file_name);
    }
    #endregion

    #region Relationships
    /**
     * retourne le type de requete|la relation eloquent.
     * @return BelongsTo
     */
    public function requesttype()
    {
        return $this->belongsTo(RequestType::class, 'request_type_id');
    }

    /**
     * retourne la sim de la requete|la relation eloquent.
     * @return BelongsTo
     */
    public function sim()
    {
        return $this->belongsTo(Sim::class, 'sim_id');
    }

    /**
     *  retourne les fichiers reponses de la requete|la relation eloquent.
     * @return HasMany
     */
    public function responsefiles()
    {
        return $this->hasMany(SimRequestResponseFile::class, 'sim_request_id');
    }

    /**
     *  retourne le dernier fichier reponse de la requete|la relation eloquent.
     * @return HasOne
     */
    public function latestresponsefile()
    {
        return $this->hasOne(SimRequestResponseFile::class, 'sim_request_id')->ofMany('id', 'max');
    }

    /**
     * retourne les tentatives de traitement de la requete|la relation eloquent.
     * @return HasMany
     */
    public function treatmentattempts()
    {
        return $this->hasMany(TreatmentAttempt::class, 'sim_request_id');
    }

    /**
     * retourne la dernière tentative de traitement de la requete|la relation eloquent.
     * @return HasOne
     */
    public function latesttreatmentattempt()
    {
        return $this->hasOne(TreatmentAttempt::class, 'sim_request_id')->ofMany('id', 'max');
    }

    /**
     * retourne le traitement supérieur/parent de la requete|la relation eloquent.
     * @return BelongsTo|null
     */
    public function uppertreatment()
    {
        return null;
    }

    #endregion

    #region Insert & Update

    /**
     * retoune une requete sim à partir de son ID
     * @param $id
     * @return SimRequest|null
     */
    public static function getById($id){
        return SimRequest::find($id);
    }

    /**
     * enregistre une requete à partir de l'api
     * @param StoreSimRequestRequest $request
     * @return SimRequest
     */
    public static function registerNewRequest($request) {
        $iccid = $request->iccid;
        $url_response = $request->url_response;
        $client_key_request = $request->client_key_request;
        $client_ip_address = $request->ip();
        $file_extension = self::$FILE_EXTENSION;

        $sim = Sim::updateOrNew($iccid);

        return self::insertData($sim, $client_ip_address, $url_response, $file_extension, "", $client_key_request);
    }

    private function setCode() {
        // insertion du code de la requete
        $this->code = $this->sim->iccid . "_" . explode("-", Str::orderedUuid())[0];
        $this->file_prefix = $this->code;

        $this->save();
    }

    /**
     * Insert un nouvel objet SimRequest dans la base de données
     * @param Sim $sim
     * @param string $client_ip_address
     * @param string $url_response
     * @param string $file_extension
     * @param string $file_prefix
     * @param string $client_key_request
     * @param string $description
     * @param RequestType|null $request_type
     * @return SimRequest
     */
    public static function insertData($sim, $client_ip_address, $url_response, $file_extension, $file_prefix = "", $client_key_request = "", $description = "", $request_type = null)
    {
        $new_simrequest = self::create([
            'client_ip_address' => $client_ip_address,
            'client_key_request' => $client_key_request,
            'url_response' => $url_response,
            'file_prefix' => $file_prefix,
            'file_extension' => $file_extension,
            'description' => $description,
        ]);

        // Mettre le statut en attente
        $new_simrequest->setWaiting();

        // Assignation du type de requête
        if (is_null($request_type)) {
            // Assignation du type par défaut
            $request_type = RequestType::getDefault();
        }
        if (!is_null($request_type)) {
            $new_simrequest->requesttype()->associate($request_type);
        }

        // Assignation de la sim
        $new_simrequest->sim()->associate($sim);
        $new_simrequest->setCode();

        $new_simrequest->save();

        return $new_simrequest;


        }

    /**
     * Modifie un objet SimRequest à partir de la base de données
     * @param Sim $sim
     * @param string $client_ip_address
     * @param string $url_response
     * @param string $file_extension
     * @param string $file_prefix
     * @param string|null $client_key_request
     * @param string $description
     * @param RequestType|null $request_type
     * @return $this
     */
    public function updateOne($sim, $client_ip_address, $url_response, $file_extension, $file_prefix = "", $client_key_request = "", $description = "", $request_type = null)
    {
        $this->description = $description;
        $this->client_ip_address = $client_ip_address;
        $this->client_key_request = $client_key_request;
        $this->url_response = $url_response;
        $this->file_extension = $file_extension;
        $this->file_prefix = $file_prefix;

        if (!is_null($request_type)) {
            $this->requesttype()->associate($request_type);
        }

        // Assignation de la sim
        $this->sim()->associate($sim);

        $this->save();

        return $this;
    }

    /**
     * Modifie ou insert  un objet SimRequest dans la base de données
     * @param sim $sim
     * @param string $client_ip_address
     * @param string $url_response
     * @param string $file_extension
     * @param string $file_prefix
     * @param string|null $client_key_request
     * @param string $description
     * @param RequestType|null $request_type
     * @return SimRequest
     */
    public static function updateOrNew($sim, $client_ip_address, $url_response, $file_extension, $file_prefix = "", $client_key_request = "", $description = "", $request_type = null)
    {
        $simrequest = SimRequest::where('sim_id', $sim->id)->where('client_ip_address',$client_ip_address)->first();

        if ($simrequest) {
            return $simrequest->updateOne($sim, $client_ip_address,$url_response, $file_extension, $file_prefix,$client_key_request , $description, $request_type);
        } else {
            return SimRequest::insertData($sim, $client_ip_address, $url_response, $file_extension, $file_prefix,$client_key_request , $description, $request_type);
        }
    }
    #endregion

    #region implémentation de HasCode
    protected function getCodeSeparator()
    {
        return "";
    }
    #endregion

    #region Excute Request

    /**
     * retourne les requetes qui peuvent etre exécutés
     * @return SimRequest[]|null
     */
    public static function getTreatmentsToBeExecuted()
    {
        return SimRequest::
        where('treatment_status_id', TreatmentStatus::getWaitingStatus()->id)
            ->OrWhere('treatment_status_id', TreatmentStatus::getFailedStatus()->id)
            ->OrWhere('treatment_status_id', TreatmentStatus::getSuspendedStatus()->id)
            ->get();
    }

    /**
     * Exécute la requete
     * @return void
     */
    public function execRequest(): void
    {
        // S'il n'y a pas de tentative,
        if ($this->treatmentattempts()->count() === 0) {
            // Creer une nouvelle
            $this->startNewAttempt();
            return;
        }

        // si la requete est en attente
        if ($this->isWaiting()) {
            // Exécuter la derniere tentative
            $this->latesttreatmentattempt->execAttempt();
            return;
        }

        // si la requete est en Echec
        if ($this->isFailed()) {
            if (! $this->setMaxFailedReached() ) {

                if ( $this->latesttreatmentattempt->isMaxFailed() ) {
                    // Lancer une nouvelle tentative, si le MAX n'est pas atteint.
                    $this->startNewAttempt();
                } else {
                    $this->latesttreatmentattempt->execAttempt();
                }
            }
            return;
        }

        // si la requete est Suspend
        if ($this->isSuspended()) {
            if (! $this->setMaxSuspendedReached() ) {
                if ( $this->latesttreatmentattempt->isMaxSuspended() ) {
                    // Lancer une nouvelle tentative, si le MAX n'est pas atteint.
                    $this->startNewAttempt();
                } else {
                    $this->latesttreatmentattempt->execAttempt();
                }
            }
            return;
        }

        Log::error("execRequest - la SimRequest (" . $this->id . ") n'est pas prise en compte !!!");
    }
    #endregion

    #region Status Management
    /**
     * le statut d'un sous-traitement (Tentative) à changé
     * @param IHasTreatment|TreatmentAttempt $subtreatment
     */
    public function subTreatmentStatusChanged($subtreatment): void
    {
        if ( $subtreatment->isWaiting() ) {
            $this->setWaiting();
        } elseif ( $subtreatment->isQueueing() ) {
            $this->setQueueing();
        } elseif ( $subtreatment->isRunning() ) {
            $this->setRunning();
        } elseif ( $subtreatment->isSuccess() ) {
            $this->subTreatmentSucceed($subtreatment);
        } elseif ( $subtreatment->isFailed() ) {
            $this->subTreatmentFailed($subtreatment);
        } elseif ($subtreatment->isMaxFailed() ) {
            $this->subTreatmentFailed($subtreatment);
        } elseif ($subtreatment->isSuspended() ) {
            $this->subTreatmentSuspended($subtreatment);
        } elseif ($subtreatment->isMaxSuspended() ) {
            $this->subTreatmentMaxSuspended($subtreatment);
        }
    }

    /**
     * @param IHasTreatment $subtreatment
     */
    private function subTreatmentFailed(IHasTreatment $subtreatment): void
    {
        //-> ressayer si le nombre maximal de tentative est atteint
        if ( $this->setMaxFailedReached() ) {
            $this->subtreatmentEndWithFailure($subtreatment);
        } else {
            // sinon, Reessayer (appreter la requete pour la prochaine tache planifiee)
            $this->setFailed();
            if ($subtreatment->isMaxFailed()) {
                // cloturer le resultat en cours
                $this->subtreatmentEndWithFailure($subtreatment);
            }
        }
    }
    private function subTreatmentSuspended(IHasTreatment $subtreatment): void
    {
        //-> ressayer si le nombre maximal de tentative est atteint
        if ( $this->setMaxSuspendedReached() ) {
            $this->subtreatmentEndWithFailure($subtreatment);
        } else {
            // sinon, Reessayer (appreter la requete pour la prochaine tache planifiee)
            $this->setSuspended();
        }
    }

    /**
     * Essaie de mettre la requete max-failed si les conditions sont reunies.
     * @return bool
     */
    private function setMaxFailedReached(): bool
    {
        if ($this->treatmentattempts()->count() >= self::$MAX_ATTEMPTS_FAILED_RETRY ) {
            // Marquer le requete comme max-failed
            $this->setMaxFailed();
            // ... et, renvoyer TRUE
            return true;
        } else {
            // renvoyer FALSE
            return false;
        }
    }

    private function setMaxSuspendedReached(): bool
    {
        if ($this->treatmentattempts()->count() >= self::$MAX_ATTEMPTS_SUSPENDED_RETRY ) {
            // Marquer le requete comme max-failed
            $this->setMaxSuspended();
            // ... et, renvoyer TRUE
            return true;
        } else {
            // renvoyer FALSE
            return false;
        }
    }

    /**
     *le status :en succès
     * @param IHasTreatment $subtreatment
     */
    private function subTreatmentSucceed(IHasTreatment $subtreatment): void
    {
        // Marquer la requete comme success
        $this->setSuccess();

        // fin de la tentative de traitement
        $this->endTreatmentWithSuccess();
    }

    /**
     * * le status :en suspension
     * @param $subtreatment
     */
    private function subTreatmentMaxSuspended($subtreatment): void
    {
        // Marquer la requete comme suspended
        $this->setMaxSuspended();
    }

    /**
     * @param IHasTreatment|TreatmentAttempt $subtreatment
     */
    private function subtreatmentEndWithFailure(IHasTreatment $subtreatment): void
    {
        $attempt_no = $this->treatmentattempts()->count() + 1;
        // fin de la tentative de traitement
        $this->endTreatmentWithFailure("Echec Traitement, Tentative N° " . $attempt_no . " (" . $subtreatment->id . ")");
    }



    private function startNewAttempt(): void
    {
        $attempt_no = $this->treatmentattempts()->count() + 1;
        $treatmentattempt = TreatmentAttempt::insertData($this, "Tentative Execution N° " . $attempt_no);
        $treatmentattempt->execAttempt();

        // Creéer le Resultat de la Tentative
        $this->startTreatment("Execution Requête (" . $this->id . ") - Tentative N° " . $attempt_no);
    }
    #endregion

    public static function boot()
    {
        parent::boot();

        self::created(function (SimRequest $simrequest) {
            // insertion du file prefixe
            if (is_null($simrequest->file_prefix) || $simrequest->file_prefix === "") {
                $simrequest->file_prefix = $simrequest->code;
                $simrequest->save();
            }
        });
    }

}
