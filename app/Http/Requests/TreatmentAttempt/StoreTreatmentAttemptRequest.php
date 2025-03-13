<?php

namespace App\Http\Requests\TreatmentAttempt;

use App\Models\Treatment\TreatmentAttempt;
use App\Http\Requests\SimRequest\SimRequestRequest;
use  \Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class StoreTreatmentAttemptRequest
 * @package App\Http\Requests\TreatmentAttempt
 *
 */
class StoreTreatmentAttemptRequest extends SimRequestRequest
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
    public function rules(): Array
    {
        return TreatmentAttempt::createRules();
    }
}
