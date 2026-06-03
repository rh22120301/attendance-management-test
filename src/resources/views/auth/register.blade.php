@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')


    <div class="register-form__content">
        <div class="register-form__heading">会員登録</div>
        <form class="form" action="/register" method="post">
            @csrf
            
            <div class="form-group">
                <div class="form__title">ユーザー名</div>
                    <input class="form__input" type="text" name="name">
                <div class="form__error">
                @error('name')
                    {{ $message }}
                @enderror
                </div>
            </div>
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
            <div class="form-group">
                <div class="form__title">確認用パスワード</div>
                    <input class="form__input" type="password" name="password_confirmation">
                <div class="form__error">
                @error('password')
                    {{ $message }}
                @enderror
                </div>
            </div>
            
            <button class="form__button-submit" type="submit">登録する</button>           
            <a class="login-page" href="/login">ログインはこちら</a>

        </form>
    </div>
</div>
@endsection