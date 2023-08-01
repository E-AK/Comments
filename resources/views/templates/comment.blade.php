<div class="card mb-3">
    <div class="card-body" id="comment">
        @if ($comment->deleted && $displayChildComments)
            <!-- Если комментарий удален, выводим сообщение об удалении -->
            <h4 class="card-text">Комментарий удален</h4>
        @else
            <div class="d-flex justify-content-between align-items-center mb-2">
                <!-- Дата и автор комментария -->
                <span class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</span>
                <span class="text-muted">Пользователь:
                    <!-- Ссылка на страницу автора комментария -->
                    <a href="{{ url('/user', ['id' => $comment->creator->id]) }}">
                        {{ $comment->creator->lastName . ' ' . $comment->creator->name . ' ' . $comment->creator->secondName }}
                    </a>
                </span>
            </div>
            <h4 class="card-text">{{ $comment->title }}</h4>
            <p class="card-text">{{ $comment->text }}</p>

            @if (Auth::check())
                @if ($comment->creator->id === Auth::id() || $comment->userPage === Auth::id())
                    <!-- Форма для удаления комментария -->
                    <form action="{{ route('comment.delete', ['commentId' => $comment->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                    </form>
                @endif

                @if ($canReply)
                    <!-- Кнопка "Ответить", которая будет инициировать появление формы ответа -->
                    <button class="btn btn-sm btn-primary mt-2 reply-btn">Ответить</button>
                @endif
            @endif

            @if ($canReply)
                <!-- Форма для ответа на комментарий, изначально скрытая -->
                <div class="comment-form mt-2" style="display: none;">
                    @include('templates/commentForm', ['class' => '', 'commentId' => $comment->id, 'userPageId' => $userPage->id])
                </div>
            @endif
        @endif

        @if ($displayChildComments)
            <!-- Отображаем дочерние комментарии рекурсивно -->
            <div class="child-comments">
                @foreach ($comment->replies->take(5)->sortDesc() as $reply)
                    <!-- Включение шаблона для отображения дочернего комментария -->
                    @include('templates/comment', ['comment' => $reply, 'displayChildComments', $displayChildComments])
                @endforeach
                @if ($comment->replies->count() > 5)
                    <!-- Кнопка "Показать еще" для остальных дочерних комментариев, если их количество больше 5 -->
                    <button class="btn btn-sm btn-primary mt-2" id="loadMoreSubcomments" data-id="{{ $comment->id }}">Показать еще</button>
                @endif
            </div>
        @endif
    </div>
</div>
