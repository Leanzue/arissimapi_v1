<?php


namespace App\Http\Requests\RequestStatus;

use App\Models\RequestStatus;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * @method validate($rules)
 */
class StoreRequestStatusRequest extends RequestStatusRequest

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
        return RequestStatus::createRules();
    }

}
