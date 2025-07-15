<?php

namespace App\Http\Controllers\Api\Whatsapp\Instances;

use App\Http\Controllers\Controller;
use App\UseCases\Whatsapp\ReloadWhatsappInstanceService;
use Illuminate\Http\JsonResponse;

class ReloadInstanceController extends Controller
{
    public function __construct(
        protected ReloadWhatsappInstanceService $service
    ) {}

    public function __invoke(string $name): JsonResponse
    {
        return response()->json($this->service->execute($name));
    }
}
