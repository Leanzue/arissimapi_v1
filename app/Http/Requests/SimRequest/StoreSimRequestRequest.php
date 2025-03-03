<?php

namespace App\Http\Requests\SimRequest;
use App\Models\SimRequest\SimRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class StoreSimRequestRequest
 * @package App\Http\Requests\SimRequest
 *
 * @property string $iccid
 * @property string $url_response
 * @property string|null $client_key_request
 */
class StoreSimRequestRequest extends SimRequestRequest
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
        return SimRequest::createRules();
    }
}
