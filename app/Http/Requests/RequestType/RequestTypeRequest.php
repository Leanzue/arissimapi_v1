<?php


namespace App\Http\Requests\RequestType;

use App\Models\SimRequest\RequestType;
use Illuminate\Foundation\Http\FormRequest;

class  RequestTypeRequest extends FormRequest
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
    {
    }
    public function messages()
    {
        return RequestType::messagesRules();
    }
}
