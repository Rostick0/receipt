<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Requests\Auth\RegisterAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
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
        $user = JWTAuth::user();
        if (!$user->is_confirmed) throw ValidationException::withMessages([
            'email' => trans('auth.confirmed')
        ]);

        auth()->login($user, true);

        return $this->redirectProfile($token);
    }

    public function register(RegisterAuthRequest $request)
    {
        $user = User::create($request->validated());

        $token = JWTAuth::attempt($request->only(['email', 'password']));

        auth()->login(JWTAuth::user(), true);

        return $this->redirectProfile($token);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->flush();

        return redirect('/');
    }

    public static function redirectProfile($token)
    {
        return redirect('/')->withCookie(Cookie::make('token', $token, 60 * 24 * 365));

        // return auth()->user()->is_admin ? redirect()->route('music.list') : redirect()->route('client.index', [
        //     ' => User::find(auth()->id())
        // ]);
    }
}
