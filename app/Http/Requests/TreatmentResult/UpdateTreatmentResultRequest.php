<?php

namespace App\Http\Requests\TreatmentResult;

use App\Models\Treatment\TreatmentResult;
use App\Http\Requests\SimRequest\SimRequestRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class UpdateTreatmentResultRequest
 * @package App\Http\Requests\TreatmentResult
 * @property TreatmentResult $treatmentresult
 */
class UpdateTreatmentResultRequest extends SimRequestRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return TreatmentResult::updateRules($this->treatmentresult);
    }
}
