<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Requests\Auth\RegisterAuthRequest;
use App\Models\User;
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

        return $this::redirectProfile();
    }

    public function register(RegisterAuthRequest $request)
    {
        $user = User::create($request->validated());

        auth()->login($user);

        return $this::redirectProfile();
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->flush();

        return redirect('/');
    }

    public static function redirectProfile()
    {
        
        // return auth()->user()->is_admin ? redirect()->route('music.list') : redirect()->route('client.index', [
        //     'user' => User::find(auth()->id())
        // ]);
    }
}
