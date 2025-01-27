<?php

namespace App\Http\Requests\SendStatus;

use Illuminate\Foundation\Http\FormRequest;

class StoreSendStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'priority' => 'required|string',
            'libellé' => 'required|string',
        ];
    }
}
