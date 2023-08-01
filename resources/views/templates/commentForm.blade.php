@if($auth)
    <!-- Форма для создания комментария -->
    <form class="{{ $class }}" method="POST" action="{{ route('comment.create') }}">
        @csrf

        <!-- Поле "Заголовок" -->
        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input class="form-control" id="title" name="title" required></input>

            <!-- Вывод ошибки валидации для поля "Заголовок" -->
            @error("title")
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Поле "Комментарий" -->
        <div class="mb-3">
            <label for="text" class="form-label">Комментарий</label>
            <textarea class="form-control" id="text" name="text" rows="3" required></textarea>

            <!-- Вывод ошибки валидации для поля "Комментарий" -->
            @error("text")
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Скрытые поля для передачи данных о странице пользователя и родительском комментарии -->
        <input type="hidden" name="userPageId" value="{{ $userPageId }}">
        <input type="hidden" name="parentId" value="{{ $commentId }}">

        <!-- Кнопка "Оставить комментарий" -->
        <button class="btn btn-primary w-100 py-2" type="submit">Оставить комментарий</button>
    </form>
@endif
