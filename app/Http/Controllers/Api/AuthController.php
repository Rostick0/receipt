<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAuthRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(LoginAuthRequest $request)
    {
        if (!$token = JWTAuth::attempt($request->validated())) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }

        return new JsonResponse([
            'data' => [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')?->factory()->getTTL() * 60 * 24 * 7,
                'user' => auth()->user()
            ]
        ]);
    }

    public function me()
    {
        return new JsonResponse([
            'data' => auth()->user()
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();

        return new JsonResponse([
            'message' => 'Выход из приложения'
        ]);
    }
}
