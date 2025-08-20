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
            'is_recurring' => 'sometimes|boolean',
            'recurrence_type' => 'sometimes|string|in:daily,weekly,monthly,quarterly,yearly',
            'recurrence_interval' => 'sometimes|integer|min:1',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
