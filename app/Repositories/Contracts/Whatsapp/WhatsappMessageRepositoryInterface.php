<?php

namespace App\Repositories\Contracts\Whatsapp;

use App\Models\WhatsappMessage;

interface WhatsappMessageRepositoryInterface
{
    public function create(array $data): WhatsappMessage;
}
