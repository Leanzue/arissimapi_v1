<?php

namespace App\Models\SimRequest;

use App\Models\Sim\Sim;
use App\Models\BaseModel;
use App\Traits\Code\HasCode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\TreatmentAttempt\TreatmentStatus;
use App\Models\TreatmentAttempt\TreatmentAttempt;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 *class simrequests
 * @package App\Models
 *
 * @property string $code
 * @property string $client_ip_address
 * @property string $url_response
 * @property string $description
 *
 * @property integer|null $request_status_id
 * @property integer|null $request_type_id
 *
 * @property string|null $file_prefix
 * @property string|null $file_extension
 *
 * @property RequestStatus $requeststatuses
 * @property RequestType $requestTypes
 * @property Sim $sim
 * @property-read string|null $response_file_name
 *
 * @method static SimRequest create(string[] $array)
 * @method static find(int $id)
 * @property SimRequestResponseFile $latestresponsefile
 * @property TreatmentAttempt[] $treatmentattempts
 * @property TreatmentAttempt $latesttreatmentattempt
 */

class SimRequest extends BaseModel
{
    public static $REQRESPONSE_FOLDER_CONFIG_DIR = "reqresponse_folder";
    public static $WAITING_PARSE_STATUS_CODE = "tobeparsed";
    public static $REQRESPONSE_FILE_KEY= "_res";
    pUBLIC static $MAX_TREATMENT_FAILED_RETRY= 5 ;


    /** @use HasFactory<\Database\Factories\SimRequestFactory> */
    use HasFactory, HasCode;

    protected $guarded = [];


    #region validation Rules
    public static function defaultRules()
    {
        return [
            'description' => 'required|string',
            'code' => 'required|string',
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(),
            [
              'description' => ['required', 'unique:Sim_requests,NULL,id',],
              'code' => ['required', 'unique:Sim_requests,NULL,id',],
            ]
        );
    }

    public static function updateRules($id)
    {
        return array_merge(self::defaultRules(),
            [
              'description' => ['required', 'unique:Sim_requests,' . $id . ',id',],
              'code' => ['required', 'unique:Sim_requests,' . $id . ',id',],
            ]
        );
    }

    public static function messagesRules()
    {
        return [
            'description.required' => "Le champs description est obligatoire",
            'description.string' => "Le champs  description doit etre une chaine de caracteres",
            'date.required' => "Le champs date est obligatoire",
            'date.string' => "Le champs  date doit etre une chaine de caracteres",
            'code.required' => "Le champs code est obligatoire",
            'code.string' => "Le champs  priority doit etre une chaine de caracteres",
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
    #endregion

    #region Relationships
    /**
     * @return BelongsTo
     */
    public function requeststatus()
    {
        return $this->belongsTo(RequestStatus::class, 'request_status_id');
    }

    public function requesttype()
    {
        return $this->belongsTo(RequestType::class, 'request_type_id');
    }

    public function sim()
    {
        return $this->belongsTo(Sim::class, 'sim_id');
    }

    public function responsefiles()
    {
        return $this->hasMany(SimRequestResponseFile::class, 'sim_request_id');
    }

    public function latestresponsefile()
    {
        return $this->hasOne(SimRequestResponseFile::class, 'sim_request_id')->ofMany('id', 'max');
    }

    public function treatmentattempts()
    {
        return $this->hasMany(TreatmentAttempt::class, 'sim_request_id');
    }

    public function latesttreatmentattempt()
    {
        return $this->hasOne(TreatmentAttempt::class, 'sim_request_id')->ofMany('id', 'max');
    }
    #endregion



    #region Gestion des Status de la Requete
    public function setWaiting()
    {
        // application du statut running (en utilisant le scope)
        $this->setRequestStatus(RequestStatus::getWaitingStatus());
    }
    public function setRunning()
    {
        // application du statut running (en utilisant le scope)
        $this->setRequestStatus(RequestStatus::getRunningStatus());
    }

    public function setWaitingParse()
    {
        // recuperation du status dont le code est WAITING_PARSE_STATUS_CODE
        $running_status = RequestStatus::where('code', self::$WAITING_PARSE_STATUS_CODE)->first();
        if ($running_status) {
            // si ce status existe, association de la cle etrangere
            $this->requeststatus()->associate($running_status)->save();
        }
    }
    /**
     * @param RequestStatus $requeststatus
     */
    private function setRequestStatus($requeststatus) {
        if ($requeststatus) {
            // si ce status existe, association de la cle etrangere
            $this->requeststatus()->associate($requeststatus)->save();
        }
    }
    #endregion

    /**
     * @return bool
     */
    public function isBatchResponseFileExists()
    {
        return File::exists($this->response_file_name);
    }

    /**
     * @return SimRequest[]|null
     */
    public static function getWaitingRequests()
    {
        return SimRequest::where('request_status_id', TreatmentStatus::getWaitingStatus()->id)->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getById($id){
        return SimRequest::find($id);
    }

    #region Insert & Update

    /**
     * @param Sim $sim
     * @param string $client_ip_address
     * @param string $url_response
     * @param string $file_extension
     * @param string $file_prefix
     * @param string $description
     * @param RequestType|null $request_type
     * @return SimRequest
     */
    public static function insertData($sim, $client_ip_address, $url_response, $file_extension, $file_prefix = "", $description = "", $request_type = null)
    {
        $new_simrequest = self::create([
            'client_ip_address' => $client_ip_address,
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

        $new_simrequest->save();

        return $new_simrequest;


        }

    /**
     * @param Sim $sim
     * @param string $client_ip_address
     * @param string $url_response
     * @param string $file_extension
     * @param string $file_prefix
     * @param string $description
     * @param RequestType|null $request_type
     * @return $this
     */
    public function updateOne($sim, $client_ip_address, $url_response, $file_extension, $file_prefix = "", $description = "", $request_type = null)
    {
        $this->description = $description;
        $this->client_ip_address = $client_ip_address;
        $this->url_response = $url_response;
        $this->file_extension = $file_extension;
        $this->file_prefix = $file_prefix;

        if (!is_null($request_type)) {
            $this->requesttype()->associate($request_type);
        }

        $this->save();

        return $this;
    }

    /**
     * @param sim $sim
     * @param string $client_ip_address
     * @param string $url_response
     * @param string $file_extension
     * @param string $file_prefix
     * @param string $description
     * @param RequestType|null $request_type
     * @return SimRequest
     */
    public static function updateOrNew($sim, $client_ip_address, $url_response, $file_extension, $file_prefix = "", $description = "", $request_type = null)
    {
        $simrequest = SimRequest::where('sim_id', $sim->id)->where('client_ip_address',$client_ip_address)->first();

        if ($simrequest) {
            return $simrequest->updateOne($sim, $client_ip_address, $url_response, $file_extension, $file_prefix, $description, $request_type);
        } else {
            return SimRequest::insertData($sim, $client_ip_address, $url_response, $file_extension, $file_prefix, $description, $request_type);
        }
    }
    #endregion

    #region hascode
    protected function getCodeSeparator()
    {
        return "";
    }
    #endregion

    #region Excute Request

    public function execRequest()
    {
        // S'il n'y a pas de tentative,
        if ($this->treatmentattempts()->count() === 0) {
            // dd("execRequest 1ere");
            // Creer une nouvelle et l'executer
            $treatmentattempt = TreatmentAttempt::insertData($this, "premiere tentative d execution");
            $treatmentattempt->executeAttempt();
            return;
            // recuperer la dernière tentative
            $latesttreatmentattempt = $this->treatmentattempts()->latest()->firts();
            //si la derniere tentative a reussi
            if ($latestAttempt->isSuccess()) {
                // Passer à la suivante, s'il y en a une
                $nextAttempt = $this->createNextAttempt();
                if ($nextAttempt) {
                    $nextAttempt->executeAttempt();
                } else {
                    // Si aucune autre tentative n'est nécessaire, marquer la requête comme terminée
                    $this->setEnded();
                }
                // Si la tentative a échoué
                elseif ($latestAttempt->isFailed());
                //-> ressayer si le nombre maximal n'est pas atteint
                if  ( $this-> latesttreatmentattempt->treatments()->count() >= self::$MAX_TREATMENT_FAILED_RETRY ) { }
                //sinon marquer la tentative comme echec
                // si la derniere tentative est en attente
                //-> relancer la tentative

            } }
        }

        #endregion

        public static function boot()
        {
            parent::boot();

            self::created(function ($simrequest) {
                // insertion du file prefixe
                if (is_null($simrequest->file_prefix) || $simrequest->file_prefix === "") {
                    $simrequest->file_prefix = $simrequest->code;
                    $simrequest->save();
                }
            });
        }

}
