<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Метод "index".
     *
     * Этот метод отображает список всех пользователей системы.
     * Если пользователь не аутентифицирован, то некоторые элементы страницы могут быть скрыты или недоступны.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Проверяем аутентификацию текущего пользователя
        $authenticated = Auth::check();

        // Получаем всех пользователей из базы данных
        $users = User::all();

        // Отображаем страницу со списком пользователей
        return view('users', ['authenticated' => $authenticated, 'users' => $users]);
    }
}
