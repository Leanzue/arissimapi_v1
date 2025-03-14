<?php

namespace App\Http\Requests\SimResponse;

use App\Models\SimResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreSimResponseRequest extends FormRequest
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
     * @return array<string,ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return SimResponse::createRules();
    }
}
