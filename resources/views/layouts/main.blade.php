<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Подключение стилей Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <!-- Подключение шрифтов с CDN -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Подключение пользовательских стилей из файла app.css -->
    <link href="{{ asset('app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('user.users') ? 'active' : '' }}" href="/users">
                                <i class="bi bi-people">Пользователи</i>
                            </a>
                        </li>
                        <!-- Проверка аутентификации пользователя -->
                        @if($authenticated)
                            <!-- Если пользователь аутентифицирован, показать ссылки, которые доступны пользователю -->
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('profile') ? 'active' : '' }}" href="{{ route('user.user', ['userPageId' => $Auth::id()]) }}">
                                    <i class="bi bi-person">Главная</i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('comments') ? 'active' : '' }}" href="/comments">
                                    <i class="bi bi-chat-right-text">Мои комментарии</i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/logout">
                                    <i class="bi bi-box-arrow-right">Выход</i>
                                </a>
                            </li>
                        <!-- Если пользователь не аутентифицирован, показать ссылки для входа и регистрации -->
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="/login">
                                    <i class="bi bi-box-arrow-right">Вход</i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/registration">
                                    <i class="bi bi-box-arrow-right">Регистрация</i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>

            <!-- Вывод содержимого для секции 'content' -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Подключение скриптов Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
</body>
</html>
