@extends('layouts.main')

@section('title', 'Мои комментарии')

@section('content')
    <div class="container mt-4">
        @forelse ($comments as $comment)
            <!-- Включение шаблона для отображения комментариев -->
            @include('templates/comment', ['comment' => $comment, 'canReply' => false, 'displayChildComments' => false])
        @empty
            <!-- Если комментариев нет, выводим сообщение -->
            <p>{{ 'Комментариев пока нет.' }}</p>
        @endforelse
    </div>
@stop
