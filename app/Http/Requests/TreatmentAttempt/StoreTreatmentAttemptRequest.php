<?php

namespace App\Http\Requests\TreatmentAttempt;

use App\Models\Treatment;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\TreatmentAttemptRequest;
use  \Illuminate\Contracts\Validation\ValidationRule;

class StoreTreatmentAttemptRequest extends TreatmentAttemptRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,ValidationRule|array<mixed>|string>
     */
    public function messages()
    {
        return TreatmentAttempt::messagesRules();
    }
}
