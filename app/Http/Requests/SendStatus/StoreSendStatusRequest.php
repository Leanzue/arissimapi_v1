<?php

namespace App\Http\Requests\SendStatus;

use App\Models\SendStatus;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * @method validate(string[] $array)
 */
class StoreSendStatusRequest extends SendStatusRequest
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

        return [];//SendStatus::createRules();
    }
}
