<?php

namespace App\Http\Controllers\Api\Auth\ApiKeys;

use App\Http\Controllers\Controller;
use App\UseCases\Auth\ApiKeys\ListApiKeysUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListApiKeysController extends Controller
{
    public function __construct(
        protected ListApiKeysUseCase $useCase
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $response = $this->useCase->execute($partnerId);

            return response()->json([
                'success' => true,
                'response' => $response,
            ]);
        } catch (\Throwable $e) {
            logger()->error('Erro ao listar Api Keys: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Falha ao listar Api Keys.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
