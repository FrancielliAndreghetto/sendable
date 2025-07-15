<?php

namespace App\Http\Controllers\Api\Whatsapp\Instances;

use App\Http\Controllers\Controller;
use App\UseCases\Whatsapp\ListWhatsappInstancesService;
use Illuminate\Http\JsonResponse;

class ListWhatsappInstancesController extends Controller
{
    public function __construct(
        protected ListWhatsappInstancesService $service
    ) {}

    public function __invoke(): JsonResponse
    {
        return response()->json($this->service->execute());
    }
}
