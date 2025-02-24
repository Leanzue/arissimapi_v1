<?php

namespace App\Http\Requests\SendResult;

use App\Models\SendResult;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreSendResultRequest extends SendResultRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette demande.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtenez les règles de validation qui s'appliquent à la demande.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return SendResult::createRules();
    }
}
