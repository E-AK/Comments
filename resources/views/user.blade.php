@extends('layouts.main')

@section('title', 'Пользователь')

@section('content')
    <div class="container mt-4">
        <!-- Карточка с информацией о пользователе -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title">{{ 'Профиль пользователя' }}</h5>
            </div>

            <!-- Вывод информации о пользователе -->
            <div class="card-body">
                <p class="card-text">{{ 'Фамилия: ' . $userPage->lastName }}</p>
                <p class="card-text">{{ 'Имя: ' .  $userPage->name }}</p>
                <p class="card-text">{{ 'Отчество: ' . $userPage->secondName }}</p>
                <p class="card-text">{{ 'День рождения: ' . $userPage->birthday }}</p>
            </div>
        </div>

        <!-- Включение шаблона для формы комментариев -->
        @include('templates/commentForm', ['class' => 'w-75 mx-auto', 'commentId' => '', 'userPageId' => $userPage->id])

        <!-- Контейнер для вывода комментариев -->
        <div id="commentContainer">
            <!-- Включение шаблона для вывода комментариев -->
            @forelse ($comments as $comment)
                <!-- Включение шаблона для отображения комментариев -->
                @include('templates/comment', ['comment' => $comment, 'canReply' => Auth::check(), 'displayChildComments' => true])
            @empty
                <!-- Если комментариев нет, выводим сообщение -->
                <p>{{ 'Комментариев пока нет.' }}</p>
            @endforelse
        </div>

        <!-- Кнопка "Показать еще" для дополнительных комментариев, если их больше 5 -->
        @if ($overFive)
            <button class="btn btn-primary mt-2" data-id="{{ $userPage->id }}" id="loadMoreComments">Показать еще</button>
        @endif
    </div>

    <!-- Подключение библиотеки jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const loadMoreButton = $('#loadMoreComments');
        const userPageId = loadMoreButton.data('id');
        const loadMoreSubcommentsButton = $('#loadMoreSubcomments');
        const parentId = loadMoreSubcommentsButton.data('id');

        // Обработчики для кнопки "Показать еще"
        loadMoreButton.on('click', loadMoreComments);
        loadMoreSubcommentsButton.on('click', loadMoreSubcomments);

        function loadMoreSubcomments() {
            // Загрузка дополнительных комментариев
            fetchSubcomments();
        }

        function loadMoreComments() {
            // Загрузка дополнительных комментариев
            fetchComments();
        }

        function fetchSubcomments() {
            const url = `/additionalSubComments/${parentId}?userPageId=${userPageId}`;
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'html',
                success: function(data) {
                    const commentContainer = $('#comment');

                    commentContainer.append(data);

                    loadMoreSubcommentsButton.hide();
                },
                error: function(error) {
                    console.error('Ошибка при загрузке дополнительных комментариев:', error);
                }
            });
        }

        function fetchComments() {
            const url = `/additional/${userPageId}`;
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'html',
                success: function(data) {
                    const commentContainer = $('#commentContainer');

                    commentContainer.append(data);

                    loadMoreButton.hide();
                },
                error: function(error) {
                    console.error('Ошибка при загрузке дополнительных комментариев:', error);
                }
            });
        }

        $(document).ready(function() {
            // Обработчик для кнопки "Ответить" у комментариев
            $('.reply-btn').on('click', function() {
                const commentForm = $(this).siblings('.comment-form');
                commentForm.toggle();
            });
        });
    </script>
@stop
