<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function() {
    // Проверяем авторизацию пользователя
    if (Auth::check()) {
        return redirect(route('user.user', ['userPageId' => Auth::id()]));
    }

    return redirect(route('user.users'));
})->name('index');

// Группа маршрутов для комментариев, используется префикс "comment."
Route::name('comment.')->group(function () {
    // Маршрут для создания комментария
    Route::post('/comment', [App\Http\Controllers\CommentController::class, 'create'])->name('create');

    // Маршрут для удаления комментария по его ID
    Route::post('/delete/{commentId}', [App\Http\Controllers\CommentController::class, 'delete'])->name('delete');

    // Маршрут для получения дополнительных комментариев для пользователя по его ID
    Route::get('/additional/{userPageId}', [App\Http\Controllers\CommentController::class, 'getAdditionalComments'])->name('getAdditionalComments');

    // Маршрут для получения дополнительных дочерних комментариев
    Route::get('/additionalSubComments/{parentId}', [App\Http\Controllers\CommentController::class, 'getAdditionalSubcomments'])->name('getAdditionalSubcomments');

    // Маршрут для вывода списка комментариев пользователя
    Route::get('/comments', [App\Http\Controllers\CommentController::class, 'myComments'])->name('myComments');
});

// Группа маршрутов для пользователей, используется префикс "user."
Route::name('user.')->group(function () {
    // Маршрут для вывода списка пользователей
    Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users');

    // Маршрут для вывода информации об одном пользователе по его ID
    Route::get('/profile/{userPageId}', [App\Http\Controllers\UserController::class, 'index'])->name('user');

    // Маршрут для вывода страницы аутентификации
    Route::get('/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');

    // Маршрут для обработки запроса аутентификации
    Route::post('/login', [App\Http\Controllers\LoginController::class, 'login']);

    // Маршрут для выхода из системы
    Route::get('/logout', function () {
        Auth::logout();

        return redirect(route('user.users'));
    })->name('logout');

    // Маршрут для вывода страницы регистрации
    Route::get('/registration', [App\Http\Controllers\RegisterController::class, 'index'])->name('registration');

    // Маршрут для обработки запроса регистрации
    Route::post('/registration', [App\Http\Controllers\RegisterController::class, 'save']);
});
