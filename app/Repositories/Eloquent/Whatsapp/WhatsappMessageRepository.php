<?php

namespace App\Repositories\Eloquent\Whatsapp;

use App\Models\WhatsappMessage;
use App\Repositories\Contracts\Whatsapp\WhatsappMessageRepositoryInterface;

class WhatsappMessageRepository implements WhatsappMessageRepositoryInterface
{
    public function create(array $data): WhatsappMessage
    {
        return WhatsappMessage::create($data);
    }
}
