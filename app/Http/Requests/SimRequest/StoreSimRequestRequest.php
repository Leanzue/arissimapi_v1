<?php

namespace App\Http\Requests\SimRequest;
use App\Models\SimRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreSimRequestRequest extends SimRequestRequest
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
        return [];
        // SimRequest::createRules();
    }
}
