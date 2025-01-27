<?php

namespace App\Http\Requests\SendResult;

use Illuminate\Foundation\Http\FormRequest;

class StoreSendResultRequest extends FormRequest
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
            'result_description' => 'required|string',
            'nombre_tentative' => 'required|string',
            'date_envoi' => 'required|string',
            'error_code' => 'required|string',
        ];

    }
}
