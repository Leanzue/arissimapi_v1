<?php

namespace App\Http\Requests\SendAttemptResult;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSendAttemptResultRequest extends FormRequest
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
            'date_of_sending_results' => 'sometimes|string',
            'details' => 'sometimes|string',
            'error_code' => 'sometimes|string',
            'nombre_de_tentative' => 'sometimes|string',
        ];
    }
}
