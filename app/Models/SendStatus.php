<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class sendstatuses
 * @package App\Models
 *
 * @property string $priority
 * @property string $code
 * @property string $libelle
 * @property string $description
 *
 * @property SendStatus $sendstatuses
 * @method static create(array $array)
 * @method static running()
 * @method static suspended()
 */

class SendStatus extends BaseModel
{
    /** @use HasFactory<\Database\Factories\SendStatusFactory> */
    use HasFactory;

    protected $fillable = [
        'uuid',
        'priority',
        'libellé',
        'code'

    ];

    public static function defaultRules()
    {
        return [
            'priority' => 'required|string',
            'libellé' => 'required|string',
            'code' => 'required|string',
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(),
            [
                'priority' => ['required','unique:send_statuses,priority,NULL,id',],
            ]
        );
    }
    public static function updateRules($id) {
        return array_merge(self::defaultRules(),
            [
                'priority' => ['required','unique:send_statuses,priority,'.$id.',id',],
            ]
        );
    }

    public static function messagesRules()
    {
        return [
            'priority.required' => "Le champs priority est obligatoire",
            'priority.string' => "Le champs  priority doit etre une chaine de caracteres",
        ];
    }
    /**
     * @return SendStatus|TValue|null
     */
    public static function getRunningStatus() {
        return self::running()->first();
    }

    /**
     * @return SendStatus|TValue|null
     */
    public static function getSuspendedStatus() {
        return self::suspended()->first();
    }
    /**
     * @return SendStatus|TValue|null
     */
    public static function getendedStatus()
    {
        return self::ended()->first();
    }


    public function SendAttempt(): HasMany {

        return $this->hasMany(SendAttempt::class);
    }

    #region Insert & Modif Model
    public static function insertData($priority, string $libelle, string $code, string $description = null)
    {
        self::create([
            'priority' => $priority,
            'libelle' => $libelle,
            'code' => $libelle,
        ]);
    }

    public function updateOne(string $priority, string $libelle, string $code, string $description = null): static
    {
        $this->libelle = $libelle;
        $this->code = $code;
        if ( ! is_null($description) ) {
            $this->description = $description;
        }

        $this->save();

        return $this;
    }

    public static function updateOrNew($priority,string $libelle, string $code, string $description = null)
    {
        $status = SendStatus::where('code', $code)->first();

        if ($status) {
            return $status->updateOne($priority, $libelle, $code, $description);
        } else {
            return SendStatus::insertData($priority, $libelle, $code, $description);
        }
    }
    #endregion
}
