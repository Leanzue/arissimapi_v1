<?php

namespace App\Http\Requests\StatusRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusRequest extends FormRequest
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
            'name' => 'sometimes|string',
            'code' => 'sometimes|string',
            'style' => 'sometimes|string',
            'is_default' => 'sometimes|boolean',
            'description' => 'sometimes|string',
        ];
    }
}
