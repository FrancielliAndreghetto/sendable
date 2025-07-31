<?php

namespace App\Http\Requests\Whatsapp\Messages;

use Illuminate\Foundation\Http\FormRequest;

class SendWhatsappMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'instance' => 'required|string',
            'number'   => 'required|string',
            'message'  => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
