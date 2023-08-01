<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Метод "myComments".
     *
     * Этот метод отображает комментарии, созданные текущим аутентифицированным пользователем.
     * Если пользователь не аутентифицирован, то возвращается код 403 (Запрещено).
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function myComments()
    {
        $authenticated = Auth::check();

        if (!$authenticated) {
            return abort(403);
        }

        // Получаем текущего аутентифицированного пользователя
        $user = Auth::user();

        // Получаем комментарии, созданные текущим пользователем
        $comments = $user->myComments;

        return view('myComments', ['comments' => $comments, 'authenticated' => $authenticated]);
    }

    /**
     * Метод "create".
     *
     * Этот метод создает новый комментарий для аутентифицированного пользователя и указанной страницы пользователя.
     * Если пользователь не аутентифицирован, то возвращается код 403 (Запрещено).
     * При успешном создании комментария происходит перенаправление на предыдущую страницу, а в случае ошибки - перенаправление на страницу пользователя с ошибкой.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        $authenticated = Auth::check();

        if (!$authenticated) {
            return abort(403);
        }

        $userId = Auth::id();
        $userPageId = $request->input('userPageId');

        // Создаем новый комментарий
        $comment = Comment::create([
            'user_creator_id' => $userId,
            'user_page_id' => $userPageId,
            'parent_id' => $request->input('parentId'),
            'title' => $request->input('title'),
            'text' => $request->input('text'),
        ]);

        if ($comment) {
            // Перенаправляем на предыдущую страницу
            return redirect()->back();
        }

        // Перенаправляем на страницу пользователя с ошибкой
        return redirect(route('user.user', ['userPageId' => $userPageId]))->withErrors([
            'formError' => 'Ошибка создания комментария'
        ]);
    }

    /**
     * Метод "delete".
     *
     * Этот метод удаляет указанный комментарий, если аутентифицированный пользователь является создателем этого комментария
     * или если комментарий размещен на странице аутентифицированного пользователя.
     * Если пользователь не аутентифицирован, то возвращается код 403 (Запрещено).
     * В случае успешного удаления происходит перенаправление на предыдущую страницу.
     *
     * @param int $commentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($commentId)
    {
        $authenticated = Auth::check();
        $userId = Auth::id();

        if (!$authenticated) {
            return abort(403);
        }

        // Получаем комментарий по его идентификатору
        $comment = Comment::find($commentId);

        // Проверка, существует ли комментарий и пользователь является его создателем или это комментарий на странице пользователя
        if (!$comment || ($comment->creator->id !== $userId && $comment->userPage->id !== $userId)) {
            abort(403, 'У вас нет прав для удаления этого комментария.');
        }

        // Изменение значения поля deleted на true
        $comment->deleted = true;
        $comment->save();

        // Перенаправляем на предыдущую страницу
        return redirect()->back();
    }

    /**
     * Метод "getAdditionalComments".
     *
     * Этот метод отображает дополнительные комментарии для указанной страницы пользователя.
     * Если пользователь не аутентифицирован, то возвращается код 403 (Запрещено).
     * Если пользователь с указанным ID не существует, то происходит перенаправление на главную страницу с ошибкой.
     * В случае успешного выполнения происходит отображение шаблона с дополнительными комментариями.
     *
     * @param int $userPageId
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function getAdditionalComments($userPageId)
    {
        $authenticated = Auth::check();

        // Получаем пользователя по его идентификатору
        $user = User::find($userPageId);

        // Если 'id' передан в строке запроса
        if ($userPageId !== null) {
            // Получаем данные пользователя по заданному ID
            $userPage = User::find($userPageId);

            // Проверяем, существует ли пользователь с заданным ID
            if ($userPage !== null) {
                // Исправляем запрос для получения дополнительных комментариев
                $comments = $user->comments->where('parent_id', null)->sortDesc()->skip(5);

                return view('templates/additionalComments', ['comments' => $comments, 'userPage' => $userPage, 'auth' => $authenticated, 'canReply' => Auth::check()]);
            } else {
                // Обрабатываем случай, когда пользователь с заданным ID не найден
                return redirect()->route('index')->withErrors([
                    'error' => 'Пользователь не найден'
                ]);
            }
        }
    }

    public function getAdditionalSubcomments(Request $request, $parentId)
    {
        $userPage = User::find($request->input('userPageId'));

        $authenticated = Auth::check();

        $comment = Comment::find($parentId);

        $comments = $comment->replies->sortDesc()->skip(5);

        return view('templates/additionalComments', ['comments' => $comments, 'userPage' => $userPage, 'auth' => $authenticated, 'canReply' => Auth::check()]);
    }
}