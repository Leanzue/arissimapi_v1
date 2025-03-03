<?php

namespace App\Http\Requests\TreatmentStatus;

use App\Models\Treatment\TreatmentStatus;
use Illuminate\Foundation\Http\FormRequest;

class TreatmentStatusRequest extends FormRequest
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
        return TreatmentStatus::messagesRules();
    }
}
