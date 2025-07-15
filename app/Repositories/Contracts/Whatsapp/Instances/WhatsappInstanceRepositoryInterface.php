<?php

namespace App\Repositories\Contracts\Whatsapp\Instances;

use App\Models\WhatsappInstance;

interface WhatsappInstanceRepositoryInterface
{
    public function create(array $data): WhatsappInstance;
}
