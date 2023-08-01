@extends('layouts.main')

@section('title', 'Пользователи')

@section('content')
    <div class="container mt-4">
        <!-- Цикл для вывода списка пользователей -->
        @foreach ($users as $user)
            <div class="card mb-3">
                <div class="card-body">
                    <!-- Вывод информации о пользователе с ссылкой на его профиль -->
                    <p class="card-text"><a href="{{ route('user.user', ['userPageId' => $user->id]) }}">{{ $user->lastName . ' ' .  $user->name . ' ' . $user->secondName }}</a></p>
                </div>
            </div>
        @endforeach
    </div>
@stop