<?php

namespace App\DTOs\Whatsapp\Instances;

class CreateWhatsappInstanceDTO
{
    public string $name;
    public string $number;
    public string $token;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->number = $data['number'];
        $this->token = $data['token'];
    }
}
