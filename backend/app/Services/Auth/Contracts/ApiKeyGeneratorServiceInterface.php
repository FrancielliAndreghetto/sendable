<?php

namespace App\Services\Auth\Contracts;

interface ApiKeyGeneratorServiceInterface
{
    public function generate(string $partnerId): string;
}
