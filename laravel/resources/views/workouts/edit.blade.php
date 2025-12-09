<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Physilog - ワークアウト編集</title>
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
            <form id="workoutForm" method="POST" action="{{ route('workouts.update') }}">
                @csrf
                <input type="hidden" name="date" value="{{ $data['date'] ?? '' }}">
                <input type="hidden" name="exercise_id" value="{{ $data['exercise']->id ?? '' }}">
                <div> {{ isset($data['date']) ? \Carbon\Carbon::parse($data['date'])->format('Y年m月d日') : '' }}</div>
                <div id="set-list">
                    @forelse($data['workout'] as $index => $workout)
                        <div class="set-row">
                            <label class="set-label">セット {{ $loop->iteration }}</label>

                            {{-- 更新用にこのセットのレコードIDを hidden で持っておくと後で便利 --}}
                            <input type="hidden"
                                name="sets[{{ $index }}][id]"
                                value="{{ $workout->id }}">

                            <input type="number"
                                name="sets[{{ $index }}][weight]"
                                class="input-weight"
                                placeholder="重量"
                                value="{{ old("sets.$index.weight", $workout->weight) }}"
                                required> kg

                            <input type="number"
                                name="sets[{{ $index }}][reps]"
                                class="input-reps"
                                placeholder="回数"
                                value="{{ old("sets.$index.reps", $workout->reps) }}"
                                required> 回
                        </div>
                    @empty
                        {{-- もしデータがなかった場合は1行だけ空を出しておく（保険） --}}
                        <div class="set-row">
                            <label class="set-label">セット 1</label>
                            <input type="number"
                                name="sets[0][weight]"
                                class="input-weight"
                                placeholder="重量"
                                required> kg
                            <input type="number"
                                name="sets[0][reps]"
                                class="input-reps"
                                placeholder="回数"
                                required> 回
                        </div>
                    @endforelse
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