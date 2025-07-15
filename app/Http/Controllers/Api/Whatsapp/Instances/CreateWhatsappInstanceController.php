<?php

namespace App\Http\Controllers\Api\Whatsapp\Instances;

use App\Http\Controllers\Controller;
use App\Http\Requests\Whatsapp\Instances\CreateInstanceRequest;
use App\DTOs\Whatsapp\Instances\CreateWhatsappInstanceDTO;
use App\UseCases\Whatsapp\Instances\CreateWhatsappInstanceUseCase;
use Illuminate\Http\JsonResponse;

class CreateWhatsappInstanceController extends Controller
{
    public function __construct(
        protected CreateWhatsappInstanceUseCase $useCase
    ) {}

    public function __invoke(CreateInstanceRequest $request): JsonResponse
    {
        try {
            $dto = new CreateWhatsappInstanceDTO($request->validated());

            $response = $this->useCase->execute($dto);

            return response()->json([
                'success' => true,
                'response' => $response,
            ]);
        } catch (\Throwable $e) {
            logger()->error('Erro ao conectar instância: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Falha ao conectar com a instância.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
