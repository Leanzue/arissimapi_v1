<?php

namespace App\Http\Requests\Sim;

use App\Models\Sim\Sim;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class SimRequest
 * @package App\Http\Requests\Sim
 *
 * @property string $iccid
 * @property string $imsi
 * @property string $puk
 * @property string $pin
 */
class SimRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
    public function messages()
    {
        return Sim::messagesRules();
    }
}
