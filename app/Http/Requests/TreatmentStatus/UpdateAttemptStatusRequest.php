<?php

namespace App\Http\Requests\TreatmentStatus;

use App\Models\TreatmentAttempt\TreatmentStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTreatmentStatusRequest extends TreatmentStatusRequest
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
    public function rules(): array
    {     $id = $this->route('treatmentstatuses');
        return  TreatmentStatus::updateRules($id);
    }
}
