<?php


namespace App\Contrats\Treatment;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Interface IHasTreatment
 * @package App\Contrats\Treatment
 *
 * @property IHasTreatment|null $uppertreatment
 */
interface IHasTreatment extends IHasTreatmentStatus, IHasTreatmentResult
{
    /**
     * @return belongsTo
     */
    public function uppertreatment();
}
