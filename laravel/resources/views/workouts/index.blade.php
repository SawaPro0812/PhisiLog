<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Physilog - トレーニング記録</title>

    {{-- Bootstrap（モーダルに必要） --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/workout_top.css') }}">
</head>
<body>
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
                    <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                </tbody>
            </table>
        </section>

        <section class="record-section">
            <div class="record-header">
                <h3 id="work-date-h3"></h3>
                <button class="add-btn">＋ トレーニング追加</button>
                <input type="hidden" value="" id="work-date">
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

        {{-- トレーニング種目選択モーダル --}}
        <section>
            <div class="modal fade" id="exerciseModal" tabindex="-1" aria-labelledby="exerciseModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content rounded-2xl">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exerciseModalLabel">トレーニング種目を選択</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                        </div>
                        <div class="modal-body">
                            <form id="exerciseForm">
                                <input type="hidden" id="selectedDate" name="date">
                                <div class="mb-3">
                                    <label for="exercise" class="form-label">種目</label>
                                    <select class="form-select" id="exercise" name="exercise_id" required>
                                        <option value="">選択してください</option>
                                        @foreach ($data["exercises"] as $d)
                                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="nextButton" class="btn btn-primary w-100">追加</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- JS類は末尾に移動（確実に動作させるため） --}}
    <script src="{{ asset('js/lib/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/workout_top.js') }}"></script>
</body>
</html>
