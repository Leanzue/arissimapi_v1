<?php

namespace App\Http\Requests\SendAttempt;

use App\Models\SendAttempt;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreSendAttemptRequest extends SendAttemptRequest
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
        return SendAttempt::createRules();
    }
}
