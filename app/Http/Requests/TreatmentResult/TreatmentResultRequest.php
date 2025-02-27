<?php

namespace App\Http\Requests\TreatmentResult;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\TreatmentAttempt\TreatmentResult;

class TreatmentResultRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function messages()
    {
        return TreatmentResult::messagesRules();
    }
}
