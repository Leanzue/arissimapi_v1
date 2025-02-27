<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TreatmentAttempt\TreatmentResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/** * Class statuses
 * @package App\Models
 * * @property string $name
 * @property string $code
 * * @property string $style
 * * @property string $is_default
 * * @property string $description
 * * @method static active()
 * @method static inactive()
 * @method static default()
 * @method static where(string $string, $code)
 * @method static create(array $array)
 */
class Status extends Model
{
    use HasFactory;

    protected $guarded = [];

    #region validation Rules
    public static function defaultRules()
    {
        return [
            'name' => 'required|string',
            'code' => 'required|string',
            'style' => 'required|string',
            'is_default' => 'required|string',
            'description' => 'required|string',
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(), [
            'name' => ['required', 'unique:statuses,name,NULL,id'],
            'code' => ['required', 'unique:statuses,code,NULL,id'],
        ]);
    }

    public static function updateRules($id)
    {
        return array_merge(self::defaultRules(), [
            'name' => ['required', 'unique:statuses,name,' . $id . ',id'],
            'code' => ['required', 'unique:statuses,code,' . $id . ',id'],
        ]);
    }

    public static function messagesRules()
    {
        return [
            'name.required' => "Le champ name est obligatoire",
            'name.string' => "Le champ name doit être une chaîne de caractères",
            'code.required' => "Le champ code est obligatoire",
            'code.string' => "Le champ code doit être une chaîne de caractères",
        ];

    }

    #end region Rules

    public static function default()
    {
        $status = self::where('is_default', true)->first();

        return $status;
    }

    #region Insert & Update
    static function insertData($uuid, $name, $code, $style, $is_default, $description = null)
    {
        self::create([
            'uuid' => $uuid,
            'name' => $name,
            'code' => $code,
            'style' => $style,
            'is_default' => $is_default,
            'description' => $description,
        ]);
    }

    /**
     * @param string $uuid
     * @param int $name
     * @param string $code
     * @param string $style
     * @param string $is_default
     * @param string $description
     * @return $this
     */
    public function updateOne($uuid, $name, $code, $style, $is_default, $description = null)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->style = $style;
        $this->code = $code;
        $this->is_default = $is_default;
        $this->description = $description;
        if (!is_null($description)) {
            $this->description = $description;
        }

        $this->save();

        return $this;
    }

    public static function updateOrNew($uuid, $name, $code, $style, $is_default, $description = null)
    {
        $status = Status::where('code', $code)->first();

        if ($status) {
            return $status->updateOne($uuid, $name, $code, $style, $is_default, $description);
        } else {
            return Status::insertData($uuid, $name, $code, $style, $is_default, $description);
        }
    }
    #endregion

}
