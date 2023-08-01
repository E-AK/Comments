<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Метод "index".
     *
     * Этот метод отображает страницу входа пользователя, если пользователь не аутентифицирован.
     * Если пользователь уже аутентифицирован, то происходит перенаправление на главную страницу.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $authenticated = Auth::check();

        // Проверяем авторизацию пользователя
        if ($authenticated) {
            // Если пользователь уже аутентифицирован, перенаправляем на главную страницу
            return redirect(route('index'));
        }

        // Отображаем страницу входа пользователя
        return view('login', ['authenticated' => $authenticated]);
    }

    /**
     * Метод "login".
     *
     * Этот метод выполняет аутентификацию пользователя на основе переданных данных в запросе.
     * Если пользователь уже аутентифицирован, происходит перенаправление на главную страницу.
     * В случае успешной аутентификации, происходит перенаправление на главную страницу.
     * В случае ошибки аутентификации, происходит перенаправление на страницу входа с ошибкой.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Проверяем авторизацию пользователя
        if (Auth::check()) {
            // Если пользователь уже аутентифицирован, перенаправляем на главную страницу
            return redirect(route('index', ['authenticated' => $authenticated]));
        }

        // Проверяем и валидируем поля email и password
        $validateFields = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Определение флага "remember" для запоминания пользователя
        $remember = $request->has('remember');

        // Попытка аутентификации пользователя
        if (Auth::attempt($validateFields, $remember)) {
            // Если аутентификация успешна, перенаправляем на главную страницу
            return redirect(route('index'));
        }

        // Если аутентификация не удалась, перенаправляем на страницу входа с ошибкой
        return redirect(route('user.login'))->withErrors([
            'email' => 'Ошибка аутентификации'
        ]);
    }
}
