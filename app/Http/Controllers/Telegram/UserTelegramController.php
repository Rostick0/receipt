<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use App\Models\UserTelegram;
use App\Http\Requests\StoreUserTelegramRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UserTelegramController extends Controller
{
    public function store(StoreUserTelegramRequest $request)
    {
        if (!auth()->attempt($request->only(['email', 'password']))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }

        UserTelegram::firstOrCreate([
            'telegram_user_id' => $request->telegram_user_id,
            'user_id' => auth()->id()
        ]);

        return new JsonResponse([
            'message' => 'access'
        ]);
    }

    public function destroy(int $telegram_user_id)
    {
        UserTelegram::where('telegram_user_id', $telegram_user_id)->delete();

        return new JsonResponse([
            'data' => 'Deleted'
        ]);
    }

    public function me(int $telegram_user_id)
    {
        $user_telegram = UserTelegram::with(['user'])->where('telegram_user_id', $telegram_user_id)->firstOrFail();

        return new JsonResponse([
            'data' => $user_telegram
        ]);
    }
}