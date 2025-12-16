<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Physilog - パスワード再設定</title>

    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
</head>
<body>
    <header class="header">
        <h1>Physilog</h1>
    </header>

    <main class="main">
        <section class="auth-card">
            <h2 class="auth-title">パスワード再設定</h2>

            <p class="auth-description">
                登録しているメールアドレスを入力してください。<br>
                パスワード再設定用のリンクをメールでお送りします。
            </p>

            {{-- セッションステータス（送信完了メッセージなど） --}}
            @if (session('status'))
                <div class="auth-status">
                    {{ session('status') }}
                </div>
            @endif

            {{-- バリデーションエラー --}}
            @if ($errors->any())
                <div class="auth-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
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

                <div class="form-actions">
                    <button type="submit" class="auth-submit-btn">
                        パスワード再設定メールを送信
                    </button>
                </div>

                <div class="form-footer">
                    <a href="{{ route('login') }}" class="link-small">ログイン画面へ戻る</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
