<?php

namespace App\Http\Requests\SimRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSimRequestRequest extends FormRequest
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
            'description' => 'sometimes|string',
            'adresse' => 'sometimes|string',
            'date' => 'sometimes|string',
            'code' => 'sometimes|string',
        ];
    }
}
