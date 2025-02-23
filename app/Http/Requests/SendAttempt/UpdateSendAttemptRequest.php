<?php

namespace App\Http\Requests\SendAttempt;

use App\Models\SendAttempt;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSendAttemptRequest extends FormRequest
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
    {     $id = $this->route('sendattempts');
        return SendAttempt::updateRules ($id);
    }
}
