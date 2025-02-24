<?php

namespace App\Http\Requests\SendStatus;
use App\Models\SendStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSendStatusRequest extends FormRequest
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
     * @param $request
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {   $id = $this->route('sendstatuses');
        return SendStatus::updateRules($id);
    }
}
