<?php

namespace App\DTOs\Whatsapp\Instances;

class CreateWhatsappInstanceDTO
{
    public string $name;
    public string $number;
    public string $token;
    public string $external_name;
    public string $partner_id;

    public function __construct(array $data, string $partnerId)
    {
        $this->name = $data['name'];
        $this->number = $data['number'];
        $this->token = $data['token'] ?? '';
        $this->external_name = '';
        $this->partner_id = $partnerId;
    }

    public function withExternalName(string $externalName): self
    {
        return new self([
            'name' => $this->name,
            'external_name' => $externalName,
            'number' => $this->number,
            'token' => $this->token,
        ], $this->partner_id);
    }
}
