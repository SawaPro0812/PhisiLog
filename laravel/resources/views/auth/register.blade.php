<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Physilog - 新規登録</title>

    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
</head>
<body>
    <header class="header">
        <h1>Physilog</h1>
    </header>

    <main class="main">
        <section class="auth-card">
            <h2 class="auth-title">新規登録</h2>

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

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">名前</label>
                    <input id="name"
                           type="text"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           autofocus>
                </div>

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required>
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input id="password"
                           type="password"
                           name="password"
                           required
                           autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">パスワード（確認）</label>
                    <input id="password_confirmation"
                           type="password"
                           name="password_confirmation"
                           required
                           autocomplete="new-password">
                </div>

                <div class="form-actions">
                    <button type="submit" class="auth-submit-btn">
                        登録する
                    </button>
                </div>

                <div class="form-footer">
                    <span>すでにアカウントをお持ちの方</span>
                    <a href="{{ route('login') }}" class="link-small">ログインはこちら</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
