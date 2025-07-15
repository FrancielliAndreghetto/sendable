<?php

namespace App\Http\Controllers\Api\Whatsapp\Instances;

use App\Http\Controllers\Controller;
use App\UseCases\Whatsapp\DisconnectWhatsappInstanceService;
use Illuminate\Http\JsonResponse;

class DisconnectInstanceController extends Controller
{
    public function __construct(
        protected DisconnectWhatsappInstanceService $service
    ) {}

    public function __invoke(string $name): JsonResponse
    {
        return response()->json($this->service->execute($name));
    }
}
