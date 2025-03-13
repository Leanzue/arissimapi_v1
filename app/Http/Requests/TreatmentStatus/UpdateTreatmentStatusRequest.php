<?php

namespace App\Http\Requests\TreatmentStatus;

use App\Models\Treatment\TreatmentStatus;
use App\Http\Requests\SimRequest\SimRequestRequest;

/**
 * Class UpdateTreatmentStatusRequest
 * @package App\Http\Requests\TreatmentStatus
 *  @property TreatmentStatus treatmentstatus
 */
class UpdateTreatmentStatusRequest extends SimRequestRequest
{
    /**
     *
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return TreatmentStatus::updateRules($this->treatmentstatus);
    }
}
