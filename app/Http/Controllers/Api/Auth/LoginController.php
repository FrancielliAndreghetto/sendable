<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DTOs\Auth\LoginRequestDTO;
use App\Services\Auth\LoginService;

class LoginController extends Controller
{
    public function __construct(
        protected LoginService $loginService
    ) {}

    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $dto = new LoginRequestDTO($data['email'], $data['password']);

        try {
            $result = $this->loginService->execute($dto);

            return response()->json([
                'token' => $result['token'],
                'user' => $result['user'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
        }
    }
}
