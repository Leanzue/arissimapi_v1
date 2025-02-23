<?php

namespace App\Http\Requests\SendAttemptResult;

use App\Models\SendAttemptResult;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreSendAttemptResultRequest extends SensAttemptResultRequest
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
        return  [];  //SendAttemptResult::createRules();
    }

    public function prepareForValidation()
    {

    }
}
