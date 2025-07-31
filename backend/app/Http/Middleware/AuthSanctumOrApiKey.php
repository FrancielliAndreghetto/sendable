<?php

namespace App\Http\Middleware;

use App\Repositories\Contracts\Auth\ApiKeyRepositoryInterface;
use App\Repositories\Contracts\Auth\AuthTokenRepositoryInterface;
use App\Services\Auth\Contracts\AuthServiceInterface;
use Closure;
use Illuminate\Http\Request;

class AuthSanctumOrApiKey
{
    public function __construct(
        protected ApiKeyRepositoryInterface $apiKeyRepository,
        protected AuthTokenRepositoryInterface $authTokenRepository,
        protected AuthServiceInterface $authService
    ) {}

    public function handle(Request $request, Closure $next)
    {
        if ($this->authenticateWithSanctum($request) || $this->authenticateWithApiKey($request)) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    private function authenticateWithSanctum(Request $request): bool
    {
        $token = $request->bearerToken();

        if (!$token) return false;

        $accessToken = $this->authTokenRepository->findToken($token);

        if (!$accessToken || !$accessToken->tokenable) return false;

        $user = $accessToken->tokenable;
        $this->authService->login($user);

        $request->attributes->set('partner_id', $user->partner_id ?? null);
        $request->attributes->set('user_id', $user->id ?? null);

        return true;
    }

    private function authenticateWithApiKey(Request $request): bool
    {
        $apiKey = $this->extractApiKeyFromHeader($request);

        if (!$apiKey) return false;

        $apiKey = $this->apiKeyRepository->findByKey($apiKey);

        if (!$apiKey) return false;

        $request->attributes->set('partner_id', $apiKey->partner_id);

        return true;
    }

    private function extractApiKeyFromHeader(Request $request): ?string
    {
        $header = $request->header('Authorization');

        if (!preg_match('/Bearer\s(\S+)/i', $header, $matches)) return null;

        return $matches[1];
    }
}
