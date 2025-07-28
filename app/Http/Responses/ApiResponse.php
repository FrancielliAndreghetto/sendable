<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    public function successResponse($message = 'Operação realizada com sucesso.', mixed $data = null, int $status = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    public function errorResponse(string $message = 'Falha ao realizar operação.', mixed $exception = null, int $status = 500): JsonResponse
    {
        logger()->error($message . ': ' . $exception->getMessage() ?? '');

        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (config('app.debug') && $exception instanceof \Throwable) {
            $response['details'] = $exception->getMessage();
        }

        return response()->json($response, $status);
    }

    public function paginatedResponse(string $message = 'Itens buscados com sucesso', LengthAwarePaginator $paginator, int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'next_page_url' => $paginator->nextPageUrl(),
                'prev_page_url' => $paginator->previousPageUrl(),
            ],
        ], $status);
    }
}
