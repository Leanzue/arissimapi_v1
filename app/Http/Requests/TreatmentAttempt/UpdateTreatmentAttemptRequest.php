<?php

namespace App\Http\Requests\TreatmentAttempt;

use App\Models\Treatment\TreatmentAttempt;
use App\Http\Requests\SimRequest\SimRequestRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class UpdateTreatmentAttemptRequest
 * @package App\Http\Requests\TreatmentAttempt
 * * @property TreatmentAttempt $treatmentattempt
 */
class UpdateTreatmentAttemptRequest extends SimRequestRequest
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
         return  TreatmentAttempt::updateRules($this->treatmentattempt);
    }
}
