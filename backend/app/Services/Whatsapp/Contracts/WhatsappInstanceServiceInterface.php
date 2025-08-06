<?php

namespace App\Services\Whatsapp\Contracts;

use App\DTOs\Whatsapp\Instances\CreateWhatsappInstanceDTO;

interface WhatsappInstanceServiceInterface
{
    public function getInstances(): array;
    public function createInstance(CreateWhatsappInstanceDTO $dto): array;
    public function deleteInstance(string $name): array;
    public function connectInstance(string $name): array;
    public function disconnectInstance(string $name): array;
    public function reloadInstance(string $name): array;
    public function getContacts(string $name): array;
}
