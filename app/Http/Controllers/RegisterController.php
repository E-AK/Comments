<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Метод "index".
     *
     * Этот метод отображает страницу регистрации пользователя, если пользователь не аутентифицирован.
     * Если пользователь уже аутентифицирован, происходит перенаправление на главную страницу.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $authenticated = Auth::check();

        // Проверяем авторизацию пользователя
        if ($authenticated) {
            // Если пользователь уже аутентифицирован, перенаправляем на главную страницу
            return redirect()->route('index');
        }

        // Отображаем страницу регистрации пользователя
        return view('registration', ['authenticated' => $authenticated]);
    }

    /**
     * Метод "save".
     *
     * Этот метод сохраняет нового пользователя в базе данных на основе переданных данных в запросе.
     * Если пользователь уже аутентифицирован, происходит перенаправление на главную страницу.
     * Если пользователь с указанным email уже зарегистрирован, происходит перенаправление на страницу регистрации с ошибкой.
     * В случае успешной регистрации, происходит автоматическая аутентификация пользователя и перенаправление на главную страницу.
     * В случае ошибки регистрации, происходит перенаправление на страницу входа с ошибкой.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        // Проверяем авторизацию пользователя
        if (Auth::check()) {
            // Если пользователь уже аутентифицирован, перенаправляем на главную страницу
            return redirect()->route('index');
        }

        // Проверяем и валидируем поля для регистрации пользователя
        $validateFields = $request->validate([
            'lastName' => 'required|string',
            'name' => 'required|string',
            'secondName' => 'nullable|string',
            'birthday' => 'required|date',
            'email' => 'required|email',
            'password' => 'required|string',
            'confirmPassword' => 'required|string',
        ]);

        if ($request->input('password') !== $request->input('confirmPassword')) {
            // Если пароли не совпадают, перенаправляем на страницу регистрации с ошибкой
            return redirect()->route('registration')->withErrors([
                'confirmPassword' => 'Пароли не совпадают'
            ])->withInput(); // Сохраняем введенные данные для повторного заполнения формы
        }

        // Проверяем, существует ли пользователь с указанным email в базе данных
        if (User::where('email', $validateFields['email'])->exists()) {
            // Если пользователь с указанным email уже зарегистрирован, перенаправляем на страницу регистрации с ошибкой
            return redirect()->route('registration')->withErrors([
                'email' => 'Пользователь уже зарегистрирован'
            ])->withInput(); // Сохраняем введенные данные для повторного заполнения формы
        }

        // Создаем нового пользователя в базе данных на основе переданных данных
        $user = User::create($validateFields);

        // Проверяем, успешно ли прошла регистрация
        if ($user) {
            // Если успешно, автоматически аутентифицируем пользователя и перенаправляем на главную страницу
            Auth::login($user);
            return redirect()->route('index');
        }

        // Если регистрация не удалась, перенаправляем на страницу входа с ошибкой
        return redirect()->route('login')->withErrors([
            'formError' => 'Ошибка регистрации'
        ]);
    }
}
