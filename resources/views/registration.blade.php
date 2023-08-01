@extends('layouts.main')

@section('title', 'Регистрация')

@section('content')
    <main class="form-signin d-flex justify-content-center align-items-center vh-100">
        <form class="w-50" method="POST" action="{{ route('registration') }}">
            @csrf

            <h1 class="h3 mb-3 fw-normal" align="center">Регистрация</h1>

            <!-- Поля для ввода Фамилии, Имени и Отчества -->
            <div class="form-floating">
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Иванов" required>
                <label for="lastName">Фамилия</label>

                @error("lastName")
                    <!-- Вывод ошибки валидации для поля "Фамилия" -->
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating">
                <input type="text" class="form-control" id="name" name="name" placeholder="Иван">
                <label for="name">Имя</label>

                @error("name")
                    <!-- Вывод ошибки валидации для поля "Имя" -->
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating">
                <input type="text" class="form-control" id="secondName" name="secondName" placeholder="Иванович">
                <label for="secondName">Отчество</label>

                @error("secondName")
                    <!-- Вывод ошибки валидации для поля "Отчество" -->
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Поле "День рождения" -->
            <div class="form-group">
                <label for="birthday">День рождения</label>
                <input type="date" class="form-control" id="birthday" name="birthday" required>
            </div>

            <!-- Поле "Email" -->
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="example@mail.ru" required>
                <label for="email">Email</label>

                @error("email")
                    <!-- Вывод ошибки валидации для поля "Email" -->
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Поле "Пароль" и "Подтверждение пароля" -->
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password">Пароль</label>

                @error("password")
                    <!-- Вывод ошибки валидации для поля "Пароль" -->
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating">
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Password" required>
                <label for="confirmPassword">Подтверждение пароля</label>

                @error("confirmPassword")
                    <!-- Вывод ошибки валидации для поля "Подтверждение пароля" -->
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Кнопка "Регистрация" -->
            <button class="btn btn-primary w-100 py-2" type="submit">Регистрация</button>
        </form>
    </main>
@stop
