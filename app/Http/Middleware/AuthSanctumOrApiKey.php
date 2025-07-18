<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\ApiKey;

class AuthSanctumOrApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if ($token) {
            $accessToken = PersonalAccessToken::findToken($token);
            if ($accessToken && $accessToken->tokenable) {
                Auth::login($accessToken->tokenable);

                $request->attributes->set('partner_id', $accessToken->tokenable->partner_id ?? null);
                $request->attributes->set('user_id', $accessToken->tokenable->id ?? null);

                return $next($request);
            }
        }

        $header = $request->header('Authorization');
        if (!$header || !preg_match('/Bearer\s(\S+)/', $header, $matches)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $apiKey = $matches[1];

        $key = ApiKey::where('key', $apiKey)->first();
        if (!$key) {
            return response()->json(['message' => 'Invalid API key'], 401);
        }

        $request->attributes->set('partner_id', $key->partner_id);

        return $next($request);
    }
}
