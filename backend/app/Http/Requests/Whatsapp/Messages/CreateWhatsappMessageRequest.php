<?php

namespace App\Http\Requests\Whatsapp\Messages;

use Illuminate\Foundation\Http\FormRequest;

class CreateWhatsappMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'instance_id' => 'required|string',
            'contact_id' => 'nullable|array',
            'number' => 'nullable|string',
            'name' => 'required|string',
            'message' => 'required|string',
            'scheduled_date' => 'nullable|date_format:Y-m-d H:i:s',
            'custom_code' => 'nullable|string',
            'sent_at' => 'nullable|date_format:Y-m-d H:i:s',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
