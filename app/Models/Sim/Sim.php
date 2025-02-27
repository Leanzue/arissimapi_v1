<?php

namespace App\Models\Sim;

use App\Models\BaseModel;
use App\Models\SimRequest\SimRequest;
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
 * @method static create(string[] $entry)
 * @method static where(string $string, $iccid)
 */
class Sim extends BaseModel
{
    /** @use HasFactory<\Database\Factories\SimFactory> */
    use HasFactory;
    protected $guarded =[] ;

    #region validation Rules
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
    #end region Rules


 #region relationship

    /**
     * @return HasMany
     */
    public function SimRequests()
    {
        return $this->hasMany(SimRequest::class);
     }
     #end relationship


    #region Insert & Update

    /**
     * @param string $iccid
     * @param string $imsi
     * @param string $puk
     * @param string|null $pin
     */
    public static function insertData($iccid,$imsi,$puk,$pin = null)
    {
        self::create([
            'iccid' => $iccid,
            'imsi' => $imsi,
            'puk' => $puk,
            'pin' => $pin,
        ]);
    }

    /**
     * @param string $iccid
     * @param string $imsi
     * @param string $puk
     * @param string|null $pin
     * @return $this
     */
    public function updateOne( $iccid,  $imsi,  $puk,  $pin = null)
    {
        $this->iccid = $iccid;
        $this->imsi = $imsi;
        $this->puk = $puk;
        $this->pin = $pin;

        $this->save();

        return $this;
    }

    public static function updateOrNew( $iccid,$imsi,$puk,$pin = null)
    {
        $sim = Sim::where('iccid', $iccid)->where('imsi',$imsi)->first();

        if ($sim) {
            return $sim->updateOne($iccid,$imsi,$puk, $pin);
        } else {
            return Sim::insertData($iccid,$imsi,$puk, $pin);
        }
    }
    #endregion



}
