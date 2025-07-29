<?php

namespace App\Services\Auth;

use App\Services\Auth\Contracts\ApiKeyGeneratorServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ApiKeyGeneratorService implements ApiKeyGeneratorServiceInterface
{
    public function generate(string $partnerId): string
    {
        return hash('sha512', Str::uuid() . Carbon::now()->timestamp . $partnerId);
    }
}
