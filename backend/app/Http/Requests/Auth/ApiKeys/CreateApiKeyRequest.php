<?php

namespace App\Http\Requests\Auth\ApiKeys;

use Illuminate\Foundation\Http\FormRequest;

class CreateApiKeyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $validScopes = ['read', 'write', 'delete', 'update'];

        return [
            'name' => 'required|string',
            'name' => 'required|string',
            'scopes' => 'nullable|array',
            'scopes.*' => 'in:' . implode(',', $validScopes),
            'expires_at' => 'nullable|date',
        ];
    }
}
