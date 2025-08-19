<?php

namespace App\Http\Controllers\Api\Whatsapp\Instances;

use App\Http\Controllers\Controller;
use App\Http\Requests\Whatsapp\Instances\CreateWhatsappInstanceRequest;
use App\DTOs\Whatsapp\Instances\CreateWhatsappInstanceDTO;
use App\UseCases\Whatsapp\Instances\CreateWhatsappInstanceUseCase;
use Illuminate\Http\JsonResponse;

class CreateWhatsappInstanceController extends Controller
{
    public function __construct(
        private readonly CreateWhatsappInstanceUseCase $useCase
    ) {}

    public function __invoke(CreateWhatsappInstanceRequest $request): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $dto = new CreateWhatsappInstanceDTO($request->validated(), $partnerId);

            $response = $this->useCase->execute($dto);

            return $this->successResponse('Instância criada com sucesso.', $response, 201);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao criar a instância.',
                $exception
            );
        }
    }
}
