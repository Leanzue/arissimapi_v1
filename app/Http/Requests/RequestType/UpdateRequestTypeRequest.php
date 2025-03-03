<?php

namespace App\Http\Requests\RequestType;



use App\Http\Requests\Sim\SimRequest;
use App\Models\SimRequest\RequestType;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * @property RequestType $requesttype
 */
class UpdateRequestTypeRequest extends SimRequest
{
    /**
     * @var mixed
     */
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
        return RequestType::updateRules($this->requesttype);
    }
}
