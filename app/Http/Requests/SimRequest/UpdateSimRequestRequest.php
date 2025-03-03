<?php

namespace App\Http\Requests\SimRequest;

use App\Models\SimRequest\SimRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class UpdateSimRequestRequest
 * @package App\Http\Requests\SimRequest
 *
 * @property SimRequest simrequest
 */

class UpdateSimRequestRequest extends SimRequestRequest
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
        return SimRequest::updateRules($this->simrequest);
    }
}
