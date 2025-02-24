<?php

namespace App\Http\Requests\status;

use App\Models\Status;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusRequest extends StatusRequest
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
        // return  Status::updateRules();
        {
            $statusId = $this->route('status');
            return (new \App\Models\Status)->updateRules($statusId);
        }
    }
}
