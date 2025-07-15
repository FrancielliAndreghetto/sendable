<?php

namespace App\Http\Controllers\Api\Whatsapp\Instances;

use App\Http\Controllers\Controller;
use App\UseCases\Whatsapp\DeleteWhatsappInstanceService;
use Illuminate\Http\JsonResponse;

class DeleteInstanceController extends Controller
{
    public function __construct(
        protected DeleteWhatsappInstanceService $service
    ) {}

    public function __invoke(string $name): JsonResponse
    {
        return response()->json($this->service->execute($name));
    }
}
