<?php

namespace App\Http\Controllers\Api\Auth\ApiKeys;

use App\DTOs\Auth\ApiKeys\CreateApiKeyDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ApiKeys\CreateApiKeyRequest;
use App\UseCases\Auth\ApiKeys\CreateApiKeyUseCase;
use Illuminate\Http\JsonResponse;

class CreateApiKeyController extends Controller
{
    public function __construct(
        protected CreateApiKeyUseCase $useCase
    ) {}

    public function __invoke(CreateApiKeyRequest $request): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');
        $userId = $request->attributes->get('user_id') ?? null;

        try {
            $dto = new CreateApiKeyDTO($request->validated(), $partnerId, $userId);

            $response = $this->useCase->execute($dto);

            return $this->successResponse('Api Key Gerada com sucesso.', $response, 201);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao criar Api Key.',
                $exception
            );
        }
    }
}
