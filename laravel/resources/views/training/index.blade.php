<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Physilog - トレーニング記録</title>
    <link rel="stylesheet" href="{{ asset('css/training.css') }}">
</head>
<body>
    <script src="{{ asset('js/lib/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/training_top.js') }}"></script>

    <header class="header">
        <h1>Physilog</h1>
        <nav>
            <a href="#">ユーザ設定</a>
        </nav>
    </header>

    <main class="main">
        <section class="calendar-section">
            <div class="month-header">
                <button id="prev-month" value=1>&lt;</button>
                <h2>2025年10月</h2>
                <button id="next-month">&gt;</button>
            </div>
            <table class="calendar">
                <thead>
                    <tr>
                        <th>日</th><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th><th>土</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="record-section">
            <div class="record-header">
                <h3>10月10日の記録</h3>
                <button class="add-btn">＋ トレーニング追加</button>
            </div>

            <table class="record-table">
                <thead>
                    <tr>
                        <th>種目</th>
                        <th>セット数</th>
                        <th>総重量</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ベンチプレス</td>
                        <td>3</td>
                        <td>1960 kg</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
