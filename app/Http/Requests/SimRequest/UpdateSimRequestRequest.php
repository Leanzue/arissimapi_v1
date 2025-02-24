<?php

namespace App\Http\Requests\SimRequest;

use App\Models\SimRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSimRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules($model): array
    {
        return SimRequest::updateRules($this->route('simrequests'));
    }
}
