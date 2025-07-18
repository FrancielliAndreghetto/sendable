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

            return response()->json([
                'success' => true,
                'response' => $response,
            ]);
        } catch (\Throwable $e) {
            logger()->error('Erro ao criar Api Key: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Falha ao criar Api Key.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
