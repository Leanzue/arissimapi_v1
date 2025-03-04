<?php

namespace App\Models\Treatment;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Models\SimRequest\SimRequest;
use App\Contrats\Treatment\IHasTreatment;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use function Carbon\this;


/**
 * Class TreatmentResult
 * @package App\Models
 *
 * @property string $resultat
 * @property string $libelle
 * @property Carbon $date_debut
 * @property Carbon $date_fin
 * @property string $details
 * @property int $posi
 *
 * @property string $hastreatmentresult_type
 * @property int $hastreatmentresult_id
 *
 * @method static create(string[] $entry)
 * @method static where(string $string, $resultat)
 */
class TreatmentResult extends BaseModel
{
    /** @use HasFactory<\Database\Factories\TreatmentResultFactory> */
    use HasFactory;
    protected $guarded = [];


    public static function defaultRules()
    {
        return [
            'details' => 'required|string',
            'libelle' => 'required|string',
            'resultat' => 'required|string',
            'comment' => 'required|string',
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(),
            [
                'resultat' => ['required','unique:TreatmentAttempt,resultat,NULL,id',],
            ]
        );
    }
    public static function updateRules($id) {
        return array_merge(self::defaultRules(),
            [
                'resultat' => ['required','unique:TreatementAttempts,resultat,'.$id.',id',],
            ]
        );
    }

    public static function messagesRules()
    {
        return [

            'resultat.required' => "Le champs code est obligatoire",
            'resultat.string' => "Le champs  resultat doit etre une chaine de caracteres",
        ];
    }

    /**
     * The Model which has this Attribute
     *
     * @return IHasTreatment|MorphTo
     */
    public function hastreatmentresult()
    {
        return $this->morphTo();
    }

    #region Insert & update
    /**
     * @param int $resultat
     * @param string $libelle
     * @param string $details
     *
     * @return self|null
     */
    public static function insertData($resultat, $libelle, $details = null)
    {
        return self::create([
            'resultat' => $resultat,
            'libelle' => $libelle,
            'details' => is_null($details) ? "" : $details,
        ]);
    }

    /**
     * @param int $resultat
     * @param string $libelle
     * @param string $details
     * @return $this
     */
    public function updateOne( $resultat, $libelle, $details = null)
    {
        $this->resultat= $resultat;
        $this->libelle= $libelle;

        if ( ! is_null($details) ) {
            $this->details = $details;
        }

        $this->save();

        return $this;
    }
    #endregion


    #region Manage Result
    /**
     * @param IHasTreatment $hastreatment
     * @param SimRequest $simrequest
     * @param string $libelle_service
     *
     * @return TreatmentResult
     */
    public static function createNewResult($hastreatment, $simrequest, $libelle_service) {
        $libelle = $libelle_service . " - Requete n° " . $simrequest->id;

        return $hastreatment->startTreatment($libelle);
    }

    public function setStart($save = true) {
        $this->date_debut = (New Carbon())->format('Y-m-d H:i:s');
        if ( $save ) {
            $this->save();
        }
    }

    public function setEnded($save = true){
        $this->date_fin = (New Carbon())->format('Y-m-d H:i:s');
        if ( $save ) {
            $this->save();
        }
    }

    /**
     * @param string $message
     *
     * @return void
     */
    public function setSuccess($message = "Succes") {
        $this->details = $message;
        $this->resultat = 1;
        $this->setEnded(false);

        $this->save();
    }

    /**
     * @param string $message
     *
     * @return void
     */
    public function setFailed($message) {
        $this->details = "Echec - " . $message;
        $this->resultat = -1;
        $this->setEnded(false);

        $this->save();
    }
    #endregion

}

