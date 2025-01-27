<?php

namespace App\Http\Requests\SendResult;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSendResultRequest extends FormRequest
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
            'result_description' => 'sometimes|string',
            'nombre_tentative' => 'sometimes|string',
            'date_envoi' => 'sometimes|string',
            'error_code' => 'sometimes|string',
        ];
    }
}
