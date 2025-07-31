<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Não autenticado. Token inválido ou ausente.',
            ], 401);
        }

        return redirect()->guest(route('login'));
    }

    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }
}
