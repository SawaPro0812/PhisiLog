<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Physilog - ワークアウト登録</title>
    <link rel="stylesheet" href="{{ asset('css/workout_create.css') }}">
</head>
<body>
    <header class="header">
        <a href="{{ route('workouts.index') }}" class="back-btn">&lt;</a>
        <h1>{{ $exercise->name ?? 'ワークアウト' }}</h1>
        <span class="menu-icon">⋯</span>
    </header>

    <main class="main">
        <section class="set-section">
            <h2>{{ $data['exercise']->name }}</h2>
            <form id="workoutForm" method="POST" action="{{ route('workouts.store') }}">
                @csrf
                <input type="hidden" name="date" value="{{ $data['date'] ?? '' }}">
                <input type="hidden" name="exercise_id" value="{{ $data['exercise']->id ?? '' }}">
                <div> {{ isset($data['date']) ? \Carbon\Carbon::parse($data['date'])->format('Y年m月d日') : '' }}</div>
                <div id="set-list">
                    <div class="set-row">
                        <label class="set-label">セット 1</label>
                        <input type="number" name="sets[0][weight]" class="input-weight" placeholder="重量" required> kg
                        <input type="number" name="sets[0][reps]" class="input-reps" placeholder="回数" required> 回
                    </div>
                    <div class="set-row">
                        <label class="set-label">セット 2</label>
                        <input type="number" name="sets[1][weight]" class="input-weight" placeholder="重量" required> kg
                        <input type="number" name="sets[1][reps]" class="input-reps" placeholder="回数" required> 回
                    </div>
                    <div class="set-row">
                        <label class="set-label">セット 3</label>
                        <input type="number" name="sets[2][weight]" class="input-weight" placeholder="重量" required> kg
                        <input type="number" name="sets[2][reps]" class="input-reps" placeholder="回数" required> 回
                    </div>
                </div>

                <div class="set-controls">
                    <button type="button" id="addSet" class="set-btn plus">＋</button>
                    <button type="button" id="removeSet" class="set-btn minus">－</button>
                </div>

                <div class="memo-section">
                    <label for="memo">メモ</label>
                    <textarea name="memo" id="memo" rows="3" placeholder="メモを入力..."></textarea>
                </div>

                <div class="submit-area">
                    <button type="submit" class="submit-btn">登録</button>
                </div>
            </form>
        </section>
    </main>
    <script src="{{ asset('js/lib/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/workout_create.js') }}"></script>
</body>
</html>