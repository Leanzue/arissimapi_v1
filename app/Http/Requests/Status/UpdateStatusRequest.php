<?php

namespace App\Http\Requests\status;

use App\Models\Status;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\SimRequest\SimRequestRequest;

/**
 * Class UpdateStatusRequest
 * @package App\Http\Requests\status
 * @property Status $status
 */
class UpdateStatusRequest extends SimRequestRequest
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
          return  Status::updateRules($this->status);

    }
}
