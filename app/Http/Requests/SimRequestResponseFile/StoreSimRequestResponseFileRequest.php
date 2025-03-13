<?php

namespace App\Http\Requests\SimRequestResponseFile;

use App\Models\SimRequest\SimRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\simResponsefileRequest\SimResponseFileRequest;

class StoreSimRequestResponseFileRequest extends SimRequest
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
        return SimResponseFileRequest::createRules();

    }
}
