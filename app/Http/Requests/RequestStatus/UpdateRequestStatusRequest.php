<?php

namespace App\Http\Requests\RequestStatus;

use App\Models\RequestStatus;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $priority
 */
class UpdateRequestStatusRequest extends RequestStatusRequest
{
    /**
     * @var mixed
     */
    private $libellé;

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
    {    $id = $this->route('requeststatuses');
        return RequestStatus::updateRules($id);
    }
}
