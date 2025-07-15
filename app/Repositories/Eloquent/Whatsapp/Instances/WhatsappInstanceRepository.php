<?php

namespace App\Repositories\Eloquent\Whatsapp\Instances;

use App\Models\WhatsappInstance;
use App\Repositories\Contracts\Whatsapp\Instances\WhatsappInstanceRepositoryInterface;

class WhatsappInstanceRepository implements WhatsappInstanceRepositoryInterface
{
    public function create(array $data): WhatsappInstance
    {
        return WhatsappInstance::create($data);
    }
}
