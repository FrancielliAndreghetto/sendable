<?php

namespace App\Http\Requests\Whatsapp\Contacts;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWhatsappContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'instance_id' => 'sometimes|string',
            'name' => 'sometimes|string',
            'number' => [
                'sometimes',
                'string',
                'regex:/^\d+[\.@\w-]+$/'
            ],
            'image' => 'sometimes|string',
        ];
    }
}
