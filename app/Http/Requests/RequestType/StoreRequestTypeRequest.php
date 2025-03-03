<?php

namespace App\Http\Requests\RequestType;

use App\Models\SimRequest\RequestType;
use Illuminate\Contracts\Validation\ValidationRule;


/**
 * @method input(string $string)
 * @method validated()
 */
class StoreRequestTypeRequest extends RequestTypeRequest
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
     * @return array<string,ValidationRule;ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
              return RequestType::createRules();
    }
}
