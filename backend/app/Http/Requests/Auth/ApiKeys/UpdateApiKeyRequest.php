<?php

namespace App\Http\Requests\Auth\ApiKeys;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApiKeyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $validScopes = ['read', 'write', 'delete', 'update'];

        return [
            'name' => 'sometimes|string',
            'active' => 'sometimes|boolean',
            'scopes' => 'sometimes|array',
            'scopes.*' => 'in:' . implode(',', $validScopes),
            'expires_at' => 'sometimes|nullable|date',
        ];
    }
}
