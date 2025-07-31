<?php

namespace App\Http\Controllers\Api\Auth\ApiKeys;

use App\Http\Controllers\Controller;
use App\UseCases\Auth\ApiKeys\GetApiKeyUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetApiKeyController extends Controller
{
    public function __construct(
        protected GetApiKeyUseCase $useCase
    ) {}

    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $response = $this->useCase->execute($uuid, $partnerId);

            return $this->successResponse('Api Key consultada com sucesso.', $response);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao consultar Api Key.',
                $exception
            );
        }
    }
}
