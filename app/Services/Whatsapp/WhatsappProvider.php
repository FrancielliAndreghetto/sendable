<?php

namespace App\Services\Whatsapp;

use App\DTOs\Whatsapp\SendMessageDTO;
use GuzzleHttp\Client;

class WhatsappProvider implements WhatsappProviderInterface
{
    protected Client $client;
    protected string $baseUri;
    protected string $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUri = config('services.whatsapp.url');
        $this->apiKey = config('services.whatsapp.key');
    }

    protected function request(string $method, string $endpoint, array $options = []): array
    {
        try {
            $response = $this->client->request($method, $this->baseUri . $endpoint, array_merge([
                'headers' => [
                    'apikey' => $this->apiKey
                ]
            ], $options));

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Throwable $e) {
            report($e);
            return [];
        }
    }

    public function sendMessage(SendMessageDTO $dto): array
    {
        return $this->request('POST', "/message/sendText/{$dto->instance}", [
            'form_params' => [
                'number' => $dto->number,
                'text' => $dto->message,
            ]
        ]);
    }

    public function getInstances(): array
    {
        return $this->request('GET', '/instance/fetchInstances');
    }

    public function saveInstance(string $name, string $number, string $token): array
    {
        return $this->request('POST', '/instance/create', [
            'form_params' => [
                'instanceName' => $name,
                'integration' => 'WHATSAPP-BAILEYS',
                'token' => $token,
                'number' => $number,
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
