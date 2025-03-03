<?php

namespace App\Http\Requests\SimRequest;

use App\Models\SimRequest\SimRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class SimRequestRequest
 * @package App\Http\Requests\SimRequest
 *
 * @property string $client_ip_address
 * @property string|null $client_key_request
 * @property string $url_response
 * @property string|null $file_prefix
 * @property string|null $file_extension
 * @property string $description
 */
class SimRequestRequest extends FormRequest
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
        return SimRequest::defaultRules();
    }
    public function messages()
    {
        return SimRequest::messagesRules();
    }
}
