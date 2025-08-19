<?php

namespace App\Http\Controllers\Api\Auth\ApiKeys;

use App\DTOs\Auth\ApiKeys\UpdateApiKeyDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ApiKeys\UpdateApiKeyRequest;
use App\UseCases\Auth\ApiKeys\UpdateApiKeyUseCase;
use Illuminate\Http\JsonResponse;

class UpdateApiKeyController extends Controller
{
    public function __construct(
        private readonly UpdateApiKeyUseCase $useCase
    ) {}

    public function __invoke(UpdateApiKeyRequest $request, string $uuid): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $dto = new UpdateApiKeyDTO($request->validated());

            $response = $this->useCase->execute($uuid, $dto, $partnerId);

            return $this->successResponse('Api Key atualizada com sucesso.', $response);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao atualizar Api Key.',
                $exception
            );
        }
    }
}
