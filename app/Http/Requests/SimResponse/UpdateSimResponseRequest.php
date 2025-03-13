<?php

namespace App\Http\Requests\SimResponse;

use App\Models\SimResponse;
use App\Http\Requests\SimRequest\SimRequestRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class UpdateSimResponseRequest
 * @package App\Http\Requests\SimResponse
 * @property SimResponse $simResponse
 */

class UpdateSimResponseRequest extends SimRequestRequest
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
        return SimResponse::updateRules($this->simResponse);
    }
}
