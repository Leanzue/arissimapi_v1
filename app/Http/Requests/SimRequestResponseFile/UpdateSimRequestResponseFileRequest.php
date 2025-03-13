<?php

namespace App\Http\Requests\SimRequestResponseFile;

use App\Models\SimRequest\SimRequestResponseFile;
use App\Http\Requests\SimRequest\SimRequestRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class UpdateSimRequestResponseFileRequest
 * @package App\Http\Requests\SimRequestResponseFile
 * @property SimRequestResponseFile $simrequestresponsefile
 */
class UpdateSimRequestResponseFileRequest extends SimRequestRequest
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
        return SimRequestResponseFile::updateRules($this->simrequestresponsefile);
    }
}
