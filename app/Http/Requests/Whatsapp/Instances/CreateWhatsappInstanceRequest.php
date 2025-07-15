<?php

namespace App\Http\Requests\Whatsapp\Instances;

use Illuminate\Foundation\Http\FormRequest;

class CreateInstanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'number' => 'required|string',
            'token' => 'required|string',
        ];
    }
}
