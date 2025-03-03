<?php

namespace App\Http\Requests\Status;

use App\Models\Status;
use App\Http\Requests\Sim\SimRequest;

class StatusRequest extends SimRequest
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
        return [
            //
        ];
    }
    public function messages()
    {
        return Status::messagesRules();
    }
}
