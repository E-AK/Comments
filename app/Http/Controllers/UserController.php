<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Метод "index".
     *
     * Этот метод отображает информацию о пользователе и его комментарии.
     * Если пользователь не аутентифицирован, то некоторые элементы страницы могут быть скрыты или недоступны.
     *
     * @param int $userPageId - ID пользователя, информацию о котором нужно отобразить
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index($userPageId)
    {
        // Проверяем аутентификацию текущего пользователя
        $authenticated = Auth::check();

        // Получаем параметр 'id'
        $auth = Auth::check();

        // Находим пользователя с заданным ID в базе данных
        $user = User::find($userPageId);

        // Если 'id' передан в строке запроса
        if ($userPageId !== null) {
            // Получаем данные пользователя по заданному ID
            $userPage = User::find($userPageId);

            // Проверяем, существует ли пользователь с заданным ID
            if ($userPage !== null) {
                // Получаем комментарии пользователя, которые не были удалены и являются корневыми (без родителей)
                $comments = $user->comments->where('deleted', false)->where('parent_id', null);

                // Проверяем, превышает ли количество комментариев пользователя пять
                $overFive = $comments->count() > 5;

                // Получаем последние пять комментариев пользователя
                $comments = $comments->sortDesc()->take(5);

                // Отображаем страницу с информацией о пользователе и его комментариями
                return view('user', [
                    'authenticated' => $authenticated,
                    'userPage' => $userPage,
                    'auth' => $auth,
                    'comments' => $comments,
                    'overFive' => $overFive
                ]);
            } else {
                // Обрабатываем случай, когда пользователь с заданным ID не найден
                return redirect()->route('index')->withErrors([
                    'error' => 'Пользователь не найден'
                ]);
            }
        }

        // Возвращаем код ошибки 404, если параметр 'id' не передан или задан некорректно
        return abort(404);
    }
}
