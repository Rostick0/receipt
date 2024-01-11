<?php

namespace App\Http\Controllers;

use App\Models\UserTelegram;
use App\Http\Requests\StoreUserTelegramRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTelegramController extends Controller
{
    public function show() {
        return new JsonResponse([
            'data' => auth()->user()
        ]);
    }

    public function store(StoreUserTelegramRequest $request)
    {
        if (!$token = JWTAuth::attempt($request->only(['email', 'password']))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }

        auth()->login(JWTAuth::user(), true);

        return new JsonResponse([
            'data' => auth()->user(),
        ]);
        // UserTelegram::create([]);
    }


    public function destroy(int $id)
    {
        
    }
}
