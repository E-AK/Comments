@extends('layouts.main')

@section('title', 'Вход')

@section('content')
    <main class="form-signin d-flex justify-content-center align-items-center vh-100">
        <form class="w-50" method="POST" action="{{ route('user.login') }}">
            @csrf

            <h1 class="h3 mb-3 fw-normal" align="center">Вход</h1>

            <!-- Поле "Email" -->
            <div class="form-floating">
                <input type="email" class="form-control form-control" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}">
                <label for="email">Email</label>
            </div>

            <!-- Поле "Пароль" -->
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <label for="password">Пароль</label>
            </div>

            <!-- Флажок "Запомнить" -->
            <div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" value="remember-me" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    Запомнить
                </label>
            </div>

            <!-- Кнопка "Войти" -->
            <button class="btn btn-primary w-100 py-2" type="submit">Войти</button>
        </form>
    </main>
@stop
