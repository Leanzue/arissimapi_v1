<?php

namespace App\Http\Requests\AttemptResult;

use App\Models\AttemptResult;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreAttemptResultRequest extends AttemptResultRequest
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
        public function messages()
    {
        return AttemptResult::messagesRules();
    }

}
