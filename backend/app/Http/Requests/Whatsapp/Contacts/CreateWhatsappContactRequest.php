<?php

namespace App\Http\Requests\Whatsapp\Contacts;

use Illuminate\Foundation\Http\FormRequest;

class CreateWhatsappContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'instance_id'  => ['nullable', 'uuid'],
            'name' => 'required|string',
            'number' => [
                'required',
                'string',
                'regex:/^\d+[\.@\w-]+$/'
            ],
            'image' => 'nullable|string',
        ];
    }
}
