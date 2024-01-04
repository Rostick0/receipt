@extends('layout.index')

@section('html')
    <div class="auth">
        <form class="form auth-form" action="{{ url()->current() }}" method="POST">
            @csrf
            <div class="form__inputs auth-form__inputs">
                <label class="label">
                    <span class="label__title">E-mail</span>
                    <input class="input" type="email" name="email" required>
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </label>
                <label class="label">
                    <span class="label__title">Пароль</span>
                    <input class="input" type="password" name="password" minlength="8" required>
                    @error('password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <button class="btn auth-form__btn">Войти</button>
        </form>
        <a class="link auth__link" href="{{ route('register') }}">Регистрация</a>
    </div>
@endsection
