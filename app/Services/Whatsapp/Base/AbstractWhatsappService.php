<?php

namespace App\Services\Whatsapp\Base;

use GuzzleHttp\Client;
use RuntimeException;

abstract class AbstractWhatsappService
{
    protected Client $client;
    protected string $baseUri;
    protected string $apiKey;

    public function __construct(Client $client)
    {
        $this->client = $client;
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
            logger()->error("Erro ao fazer request para API WhatsApp: " . $e->getMessage());
            throw new RuntimeException('Erro na comunicação com a API WhatsApp.');
        }
    }
}
