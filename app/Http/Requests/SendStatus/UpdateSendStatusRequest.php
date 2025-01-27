<?php

namespace App\Http\Requests\SendStatus;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSendStatusRequest extends FormRequest
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
     * @param $request
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules($request): array
    {
        return [
            'priority' => 'sometimes|string',
            'libellé' => 'sometimes|string',

        ];
    }
}
