<?php

namespace App\Http\Requests\status;

use App\Models\Status;
use App\Http\Requests\Sim\SimRequest;
use Illuminate\Contracts\Validation\ValidationRule;


class StoreStatusRequest extends SimRequest
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

       return Status::createRules();

    }
}
