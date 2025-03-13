<?php

namespace App\Http\Requests\TreatmentStatus;

use App\Models\Treatment\TreatmentStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\SimRequest\SimRequestRequest;

class StoreTreatmentStatusRequest extends SimRequestRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return TreatmentStatus::createRules();
    }
}
