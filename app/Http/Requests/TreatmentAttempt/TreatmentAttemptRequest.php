<?php

namespace App\Http\Requests\TreatmentAttempt;

use App\Models\Treatment\TreatmentAttempt;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class TreatmentAttemptRequest extends FormRequest
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
        return TreatmentAttempt::messagesRules();
    }

}
