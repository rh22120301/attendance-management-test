@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="login-form__content">
        <div class="login-form__heading">管理者ログイン</div>
        <form class="form" action="{{ route('admin.login') }}" method="post">
        @csrf
            
            <div class="form-group">
                <div class="form__title">メールアドレス</div>
                    <input class="form__input" type="text" name="email">
                <div class="form__error">
                @error('email')
                    {{ $message }}
                @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="form__title">パスワード</div>
                    <input class="form__input" type="password" name="password">
                <div class="form__error">
                @error('password')
                    {{ $message }}
                @enderror
                </div>
            </div>

            <button class="form__button-submit" type="submit">管理者ログインする</button>

        </form>
    </div>

@endsection