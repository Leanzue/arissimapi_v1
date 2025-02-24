<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
 * @method static updateOrNew(string $string, string $string1, string $string2, string $string3, string $string4)
 */
class Status extends Model
{
use HasFactory;

protected $fillable = [
'uuid',
'name',
'code',
'style',
'is_default',
'description',
];

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

public static function insertData(string $name, string $code, string $style, string $is_default, string $description)
{
self::create([
'name' => $name,
'code' => $code,
'style' => $style,
'is_default' => $is_default,
'description' => $description,
]);
}
    public static function default()
    {
        $status = self::where('is_default', true)->first();

        return $status;
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
