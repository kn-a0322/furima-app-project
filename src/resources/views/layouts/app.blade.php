<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furima-app</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
</head>

<body>
<div class="app">
    <header class="header">
      <h1 class="header__heading">
        <img src="{{ asset('images/logo/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECH">
      </h1>
      @yield('link')
      @if (Auth::check())
        <nav class="header-nav">
          <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="header-nav__logout-button">ログアウト</button>
          </form>
          <a href="{{ route('mypage') }}" class="header-nav__mypage-link">マイページ</a>
          <a href="{{ route('sell') }}" class="header-nav__sell-link">出品</a>
        </nav>
      @else
        @if(!Route::is('login'))
        <nav class="header-nav">
          <a href="{{ route('login') }}" class="header-nav__login-link">ログイン</a>
        </nav>
        @endif
      @endif
    </header>
    <div class="content">
      @yield('content')
    </div>
  </div>
</body>

</html>