<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>COACHTECH</title>
        <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
        @yield('css')
    </head>

    <body>
        <div class="header">  
            <ul class="header-nav">
                <div class="header-title">
                    <img class="header__logo" src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt="coachtech">
                </div>

                <ul class="header-action">

                    @if (Auth::check())
                    <li class="header-nav__item">
                        <a class="header-nav__list" href="/">勤怠</a>
                    </li>
                    <li class="header-nav__item">
                        <a class="header-nav__list" href="/attendanceList">勤怠一覧</a>
                    </li>
                    <li class="header-nav__list">
                        <a class="header-nav__list" href="/stampCorrectionRequest">申請</a>
                    </li>
                    <li class="header-nav__item">
                        <form action="/logout" method="post">
                        @csrf
                        <button class="header-nav__button">ログアウト</button>
                        </form>
                    </li>
                    @endif                   
                </ul>
            </ul>
        </div>

        <main>
            @yield('content')
        </main>
    </body>
</html>