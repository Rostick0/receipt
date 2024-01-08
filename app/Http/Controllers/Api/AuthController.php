<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAuthRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginAuthRequest $request)
    {
        if (!auth()->attempt($request->validated(), true)) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }

        $token = auth()->user()->createToken('token', ['telegram'])->plainTextToken;

        return new JsonResponse([
            'data' => [
                'token' => $token
            ]
        ]);
    }

    public function logout(Request $request)
    {
        auth()->user()?->tokens()->where('abilities', '["telegram"]')->delete();
        auth()->logout();
        $request->session()->flush();

        return new JsonResponse([
            'message' => 'Выход из приложения'
        ]);
    }
}
