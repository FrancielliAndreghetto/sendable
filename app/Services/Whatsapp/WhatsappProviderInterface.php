<?php

namespace App\Services\Whatsapp;

use App\DTOs\Whatsapp\SendMessageDTO;

interface WhatsappProviderInterface
{
    public function sendMessage(SendMessageDTO $dto): array;
    public function getInstances(): array;
    public function saveInstance(string $name, string $number, string $token): array;
    public function deleteInstance(string $name): array;
    public function connectInstance(string $name): array;
    public function disconnectInstance(string $name): array;
    public function reloadInstance(string $name): array;
}
