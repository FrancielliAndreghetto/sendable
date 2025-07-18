<?php

namespace App\Http\Controllers\Api\Whatsapp\Instances;

use App\Http\Controllers\Controller;
use App\Http\Requests\Whatsapp\Instances\CreateWhatsappInstanceRequest;
use App\DTOs\Whatsapp\Instances\CreateWhatsappInstanceDTO;
use App\UseCases\Whatsapp\Instances\CreateWhatsappInstanceUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

class CreateWhatsappInstanceController extends Controller
{
    public function __construct(
        protected CreateWhatsappInstanceUseCase $useCase
    ) {}

    public function __invoke(CreateWhatsappInstanceRequest $request): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $dto = new CreateWhatsappInstanceDTO($request->validated(), $partnerId);

            $response = $this->useCase->execute($dto);

            return response()->json([
                'success' => true,
                'response' => $response,
            ]);
        } catch (\Throwable $e) {
            logger()->error('Erro ao criar instância: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Falha ao criar a instância.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
