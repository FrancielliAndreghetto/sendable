<?php

namespace App\Http\Requests\Whatsapp\Messages;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWhatsappMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'instance_id' => 'sometimes|string',
            'contact_id' => 'sometimes|array',
            'number' => 'sometimes|string',
            'name' => 'sometimes|string',
            'message' => 'sometimes|string',
            'scheduled_date' => 'sometimes|date_format:Y-m-d H:i:s',
            'custom_code' => 'sometimes|string',
            'next_send_at' => 'sometimes|date_format:Y-m-d H:i:s',
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
