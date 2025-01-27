<?php

namespace App\Http\Requests\TypeRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestTypeRequest extends FormRequest
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
            'action' => 'sometimes|string',
            'libellé' => 'sometimes|string',
        ];
    }
}
