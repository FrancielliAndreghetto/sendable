<?php

namespace App\Services\Whatsapp;

use App\DTOs\Whatsapp\Instances\CreateWhatsappInstanceDTO;
use App\Services\Whatsapp\Contracts\WhatsappInstanceServiceInterface;
use App\Services\Whatsapp\Base\AbstractWhatsappService;

class WhatsappInstanceService extends AbstractWhatsappService implements WhatsappInstanceServiceInterface
{
    public function getInstances(): array
    {
        return $this->request('GET', '/instance/fetchInstances');
    }

    public function createInstance(CreateWhatsappInstanceDTO $dto): array
    {
        return $this->request('POST', '/instance/create', [
            'form_params' => [
                'instanceName' => $dto->external_name,
                'integration' => 'WHATSAPP-BAILEYS',
                'token' => $dto->token,
                'number' => $dto->number,
            ]
        ]);
    }

    public function deleteInstance(string $name): array
    {
        return $this->request('DELETE', "/instance/delete/{$name}");
    }

    public function connectInstance(string $name): array
    {
        return $this->request('GET', "/instance/connect/{$name}");
    }

    public function disconnectInstance(string $name): array
    {
        return $this->request('DELETE', "/instance/logout/{$name}");
    }

    public function reloadInstance(string $name): array
    {
        return $this->request('POST', "/instance/restart/{$name}");
    }
}
