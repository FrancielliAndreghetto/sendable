<?php

namespace App\Http\Requests\Whatsapp\Instances;

use Illuminate\Foundation\Http\FormRequest;

class CreateWhatsappInstanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'number' => [
                'required',
                'string',
                'regex:/^\d+[\.@\w-]+$/'
            ],
            'token' => 'nullable|string',
        ];
    }
}
