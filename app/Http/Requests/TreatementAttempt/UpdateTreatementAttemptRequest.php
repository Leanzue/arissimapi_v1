<?php

namespace App\Http\Requests\TreatementAttempt;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTreatementAttemptRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date_debut' => 'sometimes|string',
            'date_fin' => 'sometimes|string',
            'resultat' => 'sometimes|string',
            'description' => 'sometimes|string',
        ];
    }
}
