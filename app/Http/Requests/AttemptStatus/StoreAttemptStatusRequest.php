<?php

namespace App\Http\Requests\AttemptStatus;

use App\Models\AttemptStatus;
use Illuminate\Foundation\Http\FormRequest;

class StoreAttemptStatusRequest extends FormRequest
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

            'nombre_essais' => 'required|string',
            'error_code' => 'required|string',
            'details' => 'required|string',
            'statut' => 'required|string',
            'comment' => 'nullable|string',

        ];
    }
}
