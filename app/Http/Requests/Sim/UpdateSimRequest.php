<?php

namespace App\Http\Requests\Sim;

use App\Models\Sim\Sim;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class UpdateSimRequest
 * @package App\Http\Requests\Sim
 *
 * @property Sim $sim
 */
class UpdateSimRequest extends SimRequest
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
        return Sim::updateRules($this->sim);
    }
}
