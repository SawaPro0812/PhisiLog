<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Physilog - 設定</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/workout_top.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
</head>
<body>
    <header class="header">
        <h1>Physilog</h1>
    </header>

    <main class="main">

        {{-- 設定 --}}
        <section class="record-section" style="margin-bottom: 20px;">
            <div class="record-header">
                <h3>設定</h3>
            </div>

            {{-- アカウント --}}
            <table class="record-table">
                <tbody>
                    <tr>
                        <th style="width: 40%;">アカウント</th>
                        <td style="text-align: right;">
                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary">ログアウト</button>
                        </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        {{-- 拡張予定（プレースホルダー） --}}
        <section class="record-section" style="background:#e0e0e0; border: none;">
            <div style="
                height: 200px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #555;
                font-size: 16px;
                letter-spacing: 1px;
            ">
                拡張予定
            </div>
        </section>

    </main>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
