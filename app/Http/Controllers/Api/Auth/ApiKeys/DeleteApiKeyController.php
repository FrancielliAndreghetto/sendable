<?php

namespace App\Http\Controllers\Api\Auth\ApiKeys;

use App\Http\Controllers\Controller;
use App\UseCases\Auth\ApiKeys\DeleteApiKeyUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteApiKeyController extends Controller
{
    public function __construct(
        protected DeleteApiKeyUseCase $useCase
    ) {}

    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $response = $this->useCase->execute($uuid, $partnerId);

            return response()->json([
                'success' => true,
                'response' => $response,
            ]);
        } catch (\Throwable $e) {
            logger()->error('Erro ao deletar a Api Key: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Falha ao deletar a Api Key.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
