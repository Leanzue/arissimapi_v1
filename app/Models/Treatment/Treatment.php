<?php

namespace App\Models\Treatment;

use App\Models\BaseModel;
use App\Jobs\Treatment\TreatmentJob;
use App\Traits\Treatment\HasTreatment;
use App\Contrats\Treatment\IHasTreatment;
use App\Events\TreatmentStatusChangedEvent;
use App\Contrats\Treatment\ITreatmentService;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Treatment
 * @package App\Models\TreatmentAttempt
 *
 * @property int $id
 * @property string|ITreatmentService $service_class
 * @property string $libelle_service
 * @property string $description
 *
 * @method static Treatment|null find(int $id)
 */
class Treatment extends BaseModel implements IHasTreatment
{
    /** @use HasFactory<\Database\Factories\TreatmentFactory> */
    use HasFactory, HasTreatment;

    protected $guarded = [];

    /**
     * @var ITreatmentService
     */
    public $service;

    #region Validation Rules
    public static function defaultRules()
    {
        return [
            'service_class' => 'nullable|string',
            'libelle_service' => 'nullable|string',
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function updateRules($id) {
        return array_merge(self::defaultRules(),
            [

            ]
        );
    }

    public static function messagesRules()
    {
        return [
            'service_class.required' => "Le service_class est obligatoire",
            'service_class.string' => "Le service_class doit être une chaine valide",

            'libelle_service.required' => "Le libelle_service est obligatoire",
            'libelle_service.string' => "Le libelle_service doit être une chaine valide",
        ];
    }
    #endregion

    #region Relationships
    /**
     * retourne le traitement supérieur/parent de la requete|la relation eloquent.
     * @return BelongsTo
     */
    public function uppertreatment()
    {
        return $this->belongsTo(TreatmentAttempt::class,"treatment_attempt_id");
    }
    #endregion

    #region Insert & Update
    /**
     * @param $id
     * @return Treatment|null
     */
    public static function getById($id) {
        return Treatment::find($id);
    }

    /**
     * Insert un nouvel Treatment dans la base de données
     *
     * @param string $service_class
     * @param string $libelle_service
     * @param string $description
     * @return Treatment
     */
    public static function insertData($service_class, $libelle_service, $description = "")
    {
        return self::create([
            'service_class' => $service_class,
            'libelle_service' => $libelle_service,
            'description' => $description,
        ]);
    }

    /**
     * Modifie un Treatment à partir de la base de données
     * @param string $service_class
     * @param string $libelle_service
     * @param string $description
     * @return $this
     */
    public function updateOne($service_class, $libelle_service, $description = "")
    {
        $this->service_class = $service_class;
        $this->libelle_service = $libelle_service;
        $this->description = $description;

        $this->save();

        return $this;
    }

    /**
     *  Modifie ou insert un Treatment à partir de la base de données
     * @param string $service_class
     * @param string $libelle_service
     * @param string $description
     *
     * @return Treatment
     */
    public static function updateOrNew($service_class, $libelle_service, $description = "")
    {
        $treatment = Treatment::where('service_class', $service_class)->where('description', $description)->first();

        if ($treatment) {
            return $treatment->updateOne($service_class, $libelle_service, $description);
        } else {
            return Treatment::insertData($service_class, $libelle_service, $description);
        }
    }
    #endregion

    #region Excute Treatment

    /**
     * exécute le traitement
     */
    public function executeTreatment() {

        // mettre le traitement comme running
        $this->setRunning();

        // et dispatcher le changement de statut
        TreatmentStatusChangedEvent::dispatch($this);

        // on instancie le service a executer
        $this->service = New $this->service_class();

        // On execute le service
        $result = $this->service->execService($this);
        //$result->refresh();
        //Log::info("Treatment - result: " . $result);
        // Setter le statut en fonction du resultat
        if ($result->resultat === 0) {
            // aucun traitement
            $this->setWaiting();

            // et dispatcher le changement de statut
            TreatmentStatusChangedEvent::dispatch($this);
        } elseif ($result->resultat === 1) {
            // succes traitement
            $this->setSuccess();
            // et dispatcher le changement de statut
            TreatmentStatusChangedEvent::dispatch($this);
        } elseif ($result->resultat === -1) {
            // échec traitement
            $this->setFailed();
            // et dispatcher le changement de statut
            TreatmentStatusChangedEvent::dispatch($this);
        } elseif ($result->resultat === 2) {
            // traitement suspendu
            $this->setSuspended();
            // et dispatcher le changement de statut
            TreatmentStatusChangedEvent::dispatch($this);
        }
    }
    public function dispatchTreatment() {
        TreatmentJob::dispatch($this);
    }
    #endregion


    #region status management
    /**
     * le statut d'un sous-traitement (Treatment) à changé
     * @param IHasTreatment|TreatmentAttempt $subtreatment
     */
    public function subTreatmentStatusChanged($subtreatment)
    {
    }
    #endregion

}
