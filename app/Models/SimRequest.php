<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Process;
use Maatwebsite\Excel\Excel as ExcelExcel;
use App\Imports\SimRequestResponseFilesImport;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Messages\MailMessage;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use function Carbon\this;


/**
 *class simrequests
 * @package App\Models
 *
 * @property string $description
 * @property string $adresse_ip
 * @property string $date
 * @property string $code
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
 * @method static create(string[] $array)
 * @method static updateOrNew(string $string, string $string1, string $string2, string $string3, string $string4, string $string5)
 */

class SimRequest extends BaseModel
{
    public static $REQRESPONSE_FOLDER_CONFIG_DIR = "reqresponse_folder";
    public static $WAITING_BATCH_STATUS_id = 2;
    public static $WAITING_PARSE_STATUS_CODE = "tobeparsed";
    public static $RUNNING_STATUS_CODE = "running";
    public static $PARSE_ERROR_STATUS_CODE = "parse_error";
    public static $DATABASE_TABLE_NAME = "arissimapidb";
    public static $REQRESPONSE_FILE_KEY= "_res";


    /** @use HasFactory<\Database\Factories\SimRequestFactory> */
    use HasFactory;

    protected $fillable = [
        'uuid',
        'description',
        'adresse_ip',
        'date',
        'code',
    ];

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

    public static function defaultRules()
    {
        return [
            'description' => 'required|string',
            'adresse_ip' => 'required|string',
            'date' => 'required|string',
            'code' => 'required|string',
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(),
            [
                'description' => ['required', 'unique:Sim_requests,NULL,id',],
                'date' => ['required', 'unique:Sim_requests,NULL,id',],
                'code' => ['required', 'unique:Sim_requests,NULL,id',],
            ]
        );
    }

    public static function updateRules($id)
    {
        return array_merge(self::defaultRules(),
            [
                'description' => ['required', 'unique:Sim_requests,' . $id . ',id',],
                'date' => ['required', 'unique:Sim_requests,' . $id . ',id',],
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

    public function requeststatus(): BelongsTo
    {
        return $this->belongsTo(requeststatus::class, 'request_status_id');
    }

    public function requesttype(): BelongsTo
    {
        return $this->belongsTo(requesttype::class, 'request_type_id');
    }

    public function sim(): BelongsTo
    {
        return $this->belongsTo(sim::class, 'sim_id');
    }

    public function setRunning()
    {
        // recuperation du status dont le code est RUNNING_STATUS_CODE
        $running_status = RequestStatus::where('code', self::$RUNNING_STATUS_CODE)->first();
        if ($running_status) {
            // si ce status existe, association de la cle etrangere
            $this->requeststatus()->associate($running_status)->save();
        }
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

    public function execBatch()
    {

    }

    /**
     * @return ExcelExcel|null
     */
    public function importFile() {
        try {
            $import_object = Excel::import(new SimRequestResponseFilesImport($this), $this->response_file_name);
            // import success
            $this->setFileImported();
            return $import_object;
        } catch (\Exception $e) {
            $this->setFileImportFail($e->getMessage());
            return null;
        }
    }

    /**
     * @return bool
     */
    public function isBatchResponseFileExists()
    {
        return File::exists($this->response_file_name);
    }


    private function parseBatchResponseFile()
    {
        // Lire le contenu du fichier
        $file_contents = File::get($this->response_file_name);

        // Traiter le contenu

        // Supposons que le fichier de réponse soit au format JSON
        $data = json_decode($file_contents, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            // JSON correctement analysé, maintenant traiter les données
            $this->handleParsedData($data);
        } else {

            // Gérer l'erreur d'analyse JSON
            $this->setParseError();
        }
    }

    private function handleParsedData(array $data)
    {
        // Traiter les données analysées selon les besoins.
        foreach ($data as $item) {
            // enregistrer dans la base de données
            $this->saveItemToDatabase($item);
        }
    }

    private function saveItemToDatabase(array $item)
    {
        // Enregistrer l'élément dans la base de données
        DB::table(self::$DATABASE_TABLE_NAME)->insert($item);
    }

    private function setParseError()
    {
        // Définir le statut en cas d'erreur d'analyse
        $parse_error_status = RequestStatus::where('code', self::$PARSE_ERROR_STATUS_CODE)->first();
        if ($parse_error_status) {
            $this->requeststatus()->associate($parse_error_status)->save();
        }
    }

       /*public function sendBatchCompletedNotification()
        {
            $mailMessage = (new MailMessage)
                ->line('Votre requête a été traitée avec succès.')
                ->action('Voir la requête', url('/requests/' . $this->id))
                ->line('Merci d\'utiliser notre application!');

            Notification::send($this->user, $mailMessage);
        }*/



    public static function insertData(string $description, string $adresse_ip, string $date, string $code)
    {
        self::create([
            'description' => $description,
            'adresse_ip' => $adresse_ip,
            'date' => $date,
            'code' => $code,
        ]);
    }

    /**
     * @return SimRequest[]|null
     */
    public static function getWaitingRequests()
    {
        return SimRequest::where('request_status_id', self::$WAITING_BATCH_STATUS_id)->get();
    }

    /**
     * @param int $id
     *
     * @return SimRequest|null
     */
    public static function getById(int $id){
        return SimRequest::find($id);
    }
    #region Insert & Modif Model
    public static function insertData($name, string $code, string $style, string $is_default,string $description  = null)
    {
        self::create([
            'name' => $name,
            'code' => $code,
            'style' => $style,
            'is_default' => $is_default,
            'description' => $description,
        ]);
    }

    public function updateOne($name, string $code, string $style, string $is_default,string $description  = null): static
    {
        $this->name = $name;
        $this->style = $style;
        $this->code = $code;
        $this->is_default = $is_default;
        if ( ! is_null($description) ) {
            $this->description = $description;
        }

        $this->save();

        return $this;
    }

    public static function updateOrNew($name, string $code, string $style, string $is_default,string $description  = null)
    {
        $status = SendStatus::where('code', $code)->first();

        if ($status) {
            return $status->updateOne($name,$code,$style,$is_default, $description);
        } else {
            return SendStatus::insertData($name,$code,$style,$is_default, $description);
        }
    }
    #endregion




}
