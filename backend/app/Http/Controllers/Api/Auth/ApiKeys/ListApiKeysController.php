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
        $perPage = $request->query('per_page', 15);
        $page = $request->query('page', 1);

        try {
            $response = $this->useCase->execute($partnerId, (int) $perPage, (int) $page);

            return $this->paginatedResponse('Api Keys consultadas com sucesso.', $response);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao listar Api Keys.',
                $exception
            );
        }
    }
}
