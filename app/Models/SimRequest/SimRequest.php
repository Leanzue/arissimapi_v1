<?php

namespace App\Models\SimRequest;

use App\Models\Sim\Sim;
use App\Models\BaseModel;
use App\Traits\Code\HasCode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\TreatmentAttempt\Treatment;
use App\Traits\TreatmentAttempt\HasTreatment;
use App\Models\TreatmentAttempt\TreatmentStatus;
use App\Models\TreatmentAttempt\TreatmentAttempt;
use Illuminate\Database\Eloquent\Factories\HasFactory;


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
 * @property int| $client_id_request
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
 *
 * @property Treatment $currenttreatment
 */

class SimRequest extends BaseModel
{
    public static $REQRESPONSE_FOLDER_CONFIG_DIR = "reqresponse_folder";
    public static $REQRESPONSE_FILE_KEY= "_res";
    pUBLIC static $MAX_ATTEMPTS_FAILED_RETRY = 5 ;


    /** @use HasFactory<\Database\Factories\SimRequestFactory> */
    use HasFactory, HasCode, HasTreatment;

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

    /**
     * @return Treatment|null
     */
    public function getCurrenttreatmentAttribute() {
        if (! $this->latesttreatmentattempt) {
            return null;
        }
        return $this->latesttreatmentattempt->latesttreatment;
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
        return SimRequest::where('treatment_status_id', TreatmentStatus::getWaitingStatus()->id)->get();
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
     * @param string $client_id_request
     * @param string $description
     * @param RequestType|null $request_type
     * @return SimRequest
     */
    public static function insertData($sim, $client_ip_address, $url_response, $file_extension, $file_prefix = "", $client_id_request = -1, $description = "", $request_type = null)
    {
        $new_simrequest = self::create([
            'client_ip_address' => $client_ip_address,
            'client_id_request' => $client_id_request,
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
     * @param int $client_id_request
     * @param string $description
     * @param RequestType|null $request_type
     * @return $this
     */
    public function updateOne($sim, $client_ip_address, $url_response, $file_extension, $file_prefix = "", $client_id_request = -1, $description = "", $request_type = null)
    {
        $this->description = $description;
        $this->client_ip_address = $client_ip_address;
        $this->client_id_request = $client_id_request;
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
     * @param sim $sim
     * @param string $client_ip_address
     * @param string $url_response
     * @param string $file_extension
     * @param string $file_prefix
     * @param string $client_id_request
     * @param string $description
     * @param RequestType|null $request_type
     * @return SimRequest
     */
    public static function updateOrNew($sim, $client_ip_address, $url_response, $file_extension, $file_prefix = "", $client_id_request = -1, $description = "", $request_type = null)
    {
        $simrequest = SimRequest::where('sim_id', $sim->id)->where('client_ip_address',$client_ip_address)->first();

        if ($simrequest) {
            return $simrequest->updateOne($sim, $client_ip_address,$url_response, $file_extension, $file_prefix,$client_id_request , $description, $request_type);
        } else {
            return SimRequest::insertData($sim, $client_ip_address, $url_response, $file_extension, $file_prefix,$client_id_request , $description, $request_type);
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
            // Creer une nouvelle
            $this->startNewAttempt();
            return;
        }

        // si la derniere tentative a reussi
        if ($this->latesttreatmentattempt->isSuccess()) {
            // Marquer la requete comme success
            $this->setSuccess();
            return;
        }

        // si la derniere tentative a échoué
        if ($this->latesttreatmentattempt->isFailed()) {
            //-> ressayer si le nombre maximal de tentative est atteint
            if ($this->treatmentattempts()->count() >= self::$MAX_ATTEMPTS_FAILED_RETRY ) {
                // Marquer le requete comme failed
                $this->setMaxFailed();
            } else {
                // sinon, Reessayer
                $this->startNewAttempt();
            }
        }
    }

    private function startNewAttempt() {
        $attempt_no = $this->treatmentattempts()->count() + 1;
        $treatmentattempt = TreatmentAttempt::insertData($this, "Tentative Execution N° " . $attempt_no);
        $treatmentattempt->executeAttempt();
        //$this->setTrying();
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
