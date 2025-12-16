<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Physilog - ログイン</title>

    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
</head>
<body>
    <header class="header">
        <h1>Physilog</h1>
        <nav>
            {{-- ログイン画面なので右側は空でもOK。必要ならリンクを置いても良い --}}
        </nav>
    </header>

    <main class="main">
        <section class="auth-card">
            <h2 class="auth-title">ログイン</h2>

            {{-- バリデーションエラー表示 --}}
            @if ($errors->any())
                <div class="auth-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus>
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input id="password"
                           type="password"
                           name="password"
                           required
                           autocomplete="current-password">
                </div>

                <div class="form-row">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>ログイン状態を保持する</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="link-small" href="{{ route('password.request') }}">
                            パスワードをお忘れですか？
                        </a>
                    @endif
                </div>

                <div class="form-actions">
                    <button type="submit" class="auth-submit-btn">
                        ログイン
                    </button>
                </div>

                @if (Route::has('register'))
                    <div class="form-footer">
                        <span>アカウントをお持ちでない方</span>
                        <a href="{{ route('register') }}" class="link-small">新規登録</a>
                    </div>
                @endif
            </form>
        </section>
    </main>
</body>
</html>
