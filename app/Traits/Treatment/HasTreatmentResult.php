<?php


namespace App\Traits\Treatment;

use App\Models\Treatment\TreatmentResult;

/**
 * Trait HasTreatmentResult
 * @package App\Traits\TreatmentAttempt
 *
 * @property-read TreatmentResult|null $firstTreatmentResult
 * @property-read TreatmentResult|null $latestTreatmentResult
 */
trait HasTreatmentResult
{
    /**
     * Renvoie les TreatmentResult de ce model.
     */
    public function treatmentresults()
    {
        return $this->morphMany(TreatmentResult::class, 'hastreatmentresult');
    }

    public function firstTreatmentResult()
    {
        return $this->morphOne(TreatmentResult::class, 'hastreatmentresult')->ofMany('posi', 'min');
    }
    public function latestTreatmentResult()
    {
        return $this->morphOne(TreatmentResult::class, 'hastreatmentresult')->latest('id');
    }

    public function oldestTreatmentResult()
    {
        return $this->morphOne(TreatmentResult::class, 'hastreatmentresult')->oldest('id');
    }

    public function addNewTreatmentResult($resultat, $libelle, $details = null) : ?TreatmentResult
    {
        $treatmentresult_count = $this->treatmentresults()->count() + 1;

        $treatmentresult = $this->treatmentresults()->create([
            'resultat' => $resultat,
            'libelle' => $libelle,
            'details' => is_null($details) ? "" : $details,
            'posi' => $treatmentresult_count,
        ]);

        return $treatmentresult;
    }

    /**
     * @param TreatmentResult $treatmentresult
     */
    public function removeTreatmentResult($treatmentresult) {
        $treatmentresult = $this->treatmentresults()->where('id', $treatmentresult->id)->first();
        if ($treatmentresult) {
            $treatmentresult->delete();
        }
    }

    public function removeTreatmentResultsAll() {
        $this->treatmentresults()->each( function($treatmentresult) {
            $treatmentresult->delete();
        });
    }

    /**
     * Add, dynamically, Eloquent relation (eager loading) to this model
     */
    protected function initializeHasTreatmentResult()
    {
        $this->with = array_unique(array_merge($this->with, ['treatmentresults','latestTreatmentResult','oldestTreatmentResult']));
    }

    public static function bootHasTreatmentResult()
    {
        static::deleting(function ($model) {
            $model->removeTreatmentResultsAll();
        });
    }
}
