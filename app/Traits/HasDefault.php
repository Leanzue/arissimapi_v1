<?php


namespace App\Traits;


use Illuminate\Support\Facades\Log;

trait HasDefault
{
    public function setDefault($new_val = 1) {

        // Get the object with this default (new) value
        $olddefault = $this->getDefault($new_val, [$this->id]);
        $old_val = $this->is_default;

        $this->update(['is_default' => $new_val]);
        if ($olddefault && ! is_null($old_val)) {
            $olddefault->setDefault($old_val);
        }

        return $this;
    }

    public function unsetDefault($id) {
        $model_type = get_called_class();
        $curr_default = $this->getDefault();

        if ($id === $curr_default->id) {
            $min_obj = $model_type::orderBy('id', 'ASC')->whereNotIn('id', [$id])->first();
            if ($min_obj) {
                $min_obj->setDefault();
            }
        }
    }

    public static function getDefault($val = 1, $exclude = []) {
        $model_type = get_called_class();
        return $model_type::where('is_default', $val)->whereNotIn('id', $exclude)->first();
    }

    public static function bootHasDefault()
    {
        static::deleting(function ($model) {
            //méthode unsetDefault si elle existe
            if (method_exists($model, 'unsetDefault')) {
                $model->unsetDefault();

            } // Suppression des fichiers associés si nécessaire
            if (property_exists($model, 'filePath') && file_exists($model->filePath)) {
                unlink($model->filePath);
            }
            // Mise à jour ou suppression de données liée
            if (method_exists($model, 'deleteRelations')) {
                $model->deleteRelations();
            }
            Log::info("Le modèle avec ID {$model->id} a été préparé pour la suppression.");
            //$model->unsetDefault($model->id);
        });
    }

}
