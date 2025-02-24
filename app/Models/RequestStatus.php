<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class requeststatuses
 * @package App\Models
 *
 * @property string $priority
 * @property string $libelle
 * @property string $code
 *
 * @property SimRequest $simrequests
 * @method static create(array $validatedData)
 * @method static running()
 * @method static suspended()
 * @method static ended()
 */
class RequestStatus extends BaseModel

{    use HasFactory;
    protected $fillable = [
        'uuid',
        'priority',
        'libellé',
        'description',
        'code',

    ];

    public static function defaultRules()
    {
        return [
            'priority' => 'required|string',
            'libellé' => 'required|string',
            'code'=>'required|string',
        ];
    }
    public static function createRules()
    {
        return array_merge(self::defaultRules(),
            [
                'priority' => ['required', 'unique:request_statuses,priority,null,id',],
                'code ' => ['required', 'unique:request_statuses,code,null,id',],

            ]
        );

    }
    public static function updateRules($id) {
        return array_merge(self::defaultRules(),
            [
                'priority' => ['required','unique:request_statuses,priority,'.$id.',id',],
                'code' => ['required','unique:request_statuses,code,'.$id.',id',],
            ]
        );
    }

    public static function messagesRules()
    {
        return [
            'priority.required' => "Le champs priority est obligatoire",
            'priority.string' => "Le champs  priority doit etre une chaine de caracteres",
            'code.required' => "Le champs  code doit etre une chaine de caracteres",
            'code.string' => "Le champs  code doit etre une chaine de caracteres",
        ];
    }

    /**
     * @return RequestStatus|TValue|null
     */
    public static function getRunningStatus() {
        return self::running()->first();
    }

    /**
     * @return RequestStatus|TValue|null
     */
    public static function getSuspendedStatus() {
        return self::suspended()->first();
    }
    /**
     * @return RequestStatus|TValue|null
     */
    public static function getendedStatus()
    {
        return self::ended()->first();
    }
       public function SimRequests(): HasMany
  {
    return $this->hasMany(SimRequest::class);
   }
    public static function insertData(string $priority, string $libelle, string $code,string $description)
    {
        self::create([
            'priority' => $priority,
            'libelle' => $libelle,
            'code' => $code,
            '$description' => $description,

        ]);
    }  public function updateOne(string $priority, string $libelle, string $code, string $description = null): static
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
        $status = RequestStatus::where('code', $code)->first();

        if ($status) {
            return $status->updateOne($priority, $libelle, $code, $description);
        } else {
            return RequestStatus::insertData($priority, $libelle, $code, $description);
        }
    }
}
