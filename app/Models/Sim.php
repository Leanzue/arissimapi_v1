<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 *class Sim
 * @package App\Models
 *
 * @property string $iccid
 * @property string $imsi
 * @property string $puk
 * @property string $pin
 *
 * @property SimRequest $simrequests
 * @method static updateOrNew(string $string, string $string1, string $string2, string $string3)
 * @method static create(string[] $entry)
 */
class Sim extends BaseModel
{
    /** @use HasFactory<\Database\Factories\SimFactory> */
    use HasFactory;
    protected $fillable = [
        'uuid',
        'iccid',
        'imsi',
        'puk',
        'pin',

    ];

    public static function defaultRules()
    {
        return [
            'iccid' => 'required|string',
            'imsi' => 'required|string',
            'puk' => 'required|string',
            'pin' => 'required|string',
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(),
            [
                'iccid' => ['required','unique:Sims,iccid,NULL,id',],
            ]
        );
    }
    public static function updateRules($id) {
        return array_merge(self::defaultRules(),
            [
                'iccid' => ['required','unique:Sims,iccid,'.$id.',id',],
            ]
        );
    }

    public static function messagesRules()
    {
        return [
            'iccid.required' => "Le champs priority est obligatoire",
            'iccid.string' => "Le champs  priority doit etre une chaine de caracteres",
        ];
    }

    public function SimRequests(): HasMany
    {
        return $this->hasMany(SimRequest::class);
    }   public static function insertData(string $iccid, string $imsi, string $puk, string $pin)
{
    self::create([
        'iccid' => $iccid,
        'imsi' => $imsi,
        'puk' => $puk,
        'pin' => $pin,

       ]);
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
