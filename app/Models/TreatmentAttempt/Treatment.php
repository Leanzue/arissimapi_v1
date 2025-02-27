<?php

namespace App\Models\TreatmentAttempt;

use App\Models\BaseModel;
use App\Jobs\SimRequestJob;
use Illuminate\Support\Carbon;
use App\Contrats\ITreatmentService;
use App\Contrats\IHasTreatmentResult;
use App\Traits\TreatmentAttempt\HasTreatment;
use App\Traits\TreatmentAttempt\HasTreatmentResult;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Treatment
 * @package App\Models\TreatmentAttempt
 *
 * @property string $service_class
 * @property string $libelle_service
 * @property Carbon $date_debut
 * @property Carbon $date_fin
 * @property string $description
 *
 * @property TreatmentAttempt|null $treatmentattempt
 */
class Treatment extends BaseModel implements IHasTreatmentResult
{
    /** @use HasFactory<\Database\Factories\TreatmentFactory> */
    use HasFactory, HasTreatment, HasTreatmentResult;

    protected $guarded = [];

    /**
     * @var ITreatmentService
     */
    protected $service;

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
     * @return BelongsTo
     */
    public function treatmentattempt()
    {
        return $this->belongsTo(TreatmentAttempt::class,"treatment_attempt_id");
    }
    #endregion

    #region Insert & Update
    /**
     * @param string $service_class
     * @param string $libelle_service
     * @param string $description
     * @return Treatment
     */
    public static function insertData($service_class, $libelle_service, $description = "")
    {
        return self::create([
            'date_debut' => (New Carbon())->format('Y-m-d H:i:s'),
            'service_class' => $service_class,
            'libelle_service' => $libelle_service,
            'description' => $description,
        ]);
    }

    /**
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
     * @param string $service_class
     * @param string $libelle_service
     * @param string $description
     *
     * @return Treatment
     */
    public static function updateOrNew($service_class, $libelle_service, $description = "")
    {
        $treatmentattempt = Treatment::where('service_class', $service_class)->where('description', $description)->first();

        if ($treatmentattempt) {
            return $treatmentattempt->updateOne($service_class, $libelle_service, $description);
        } else {
            return Treatment::insertData($service_class, $libelle_service, $description);
        }
    }
    #endregion

    #region Excute Treatment
    public function executeTreatment() {

        // dis
        SimRequestJob::dispatch($this);

        // on instancie le service a executer
        $this->service = New $this->service_class();



        // On execute le service
        $result = $this->service->execTreatment($this);

        // Setter le statut en fonction du resultat
        $result->save();
        if ($result->resultat === 0) {
            // aucun traitement
            $this->setWaiting();
        } elseif ($result->resultat === 1) {
            // succes traitement
            $this->setSuccess();
        } elseif ($result->resultat === -1) {
            // échec traitement
            $this->setFailed();
        } elseif ($result->resultat === 2) {
            // traitement suspendu
            $this->setSuspended();
        }
    }
    #endregion

    /**
     * @param int $id
     * @return Treatment
     */
    public static function getById($id) {
        return Treatment::find($id);
    }


    /**
     *
     */
    public function setQueueing() {
        $this->status = 'queueing';
        $this->save();
    }

}
