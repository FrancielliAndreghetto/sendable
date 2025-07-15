<?php

namespace App\Repositories\Eloquent\Whatsapp\Messages;

use App\Models\WhatsappMessage;
use App\Repositories\Contracts\Whatsapp\Messages\WhatsappMessageRepositoryInterface;

class WhatsappMessageRepository implements WhatsappMessageRepositoryInterface
{
    public function create(array $data): WhatsappMessage
    {
        return WhatsappMessage::create($data);
    }
}
