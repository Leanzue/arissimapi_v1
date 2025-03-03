<?php

namespace App\Http\Requests\TreatmentResult;

use App\Models\Treatment\TreatmentResult;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreTreatmentResultRequest extends TreatmentResultRequest
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
        public function messages()
    {
        return TreatmentResult::messagesRules();
    }

}
