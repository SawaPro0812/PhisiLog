<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Physilog - 種目の管理</title>

    {{-- ワークアウト画面と同じく Bootstrap を利用 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/workout_top.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/exercise.css') }}">
</head>
<body>
    <header class="header">
        <h1>Physilog</h1>
    </header>

    @php
        /** @var \Illuminate\Support\Collection|\Illuminate\Support\Enumerable|array $exercises */
        $exercises = $data['exercises'] ?? collect();
    @endphp

    <main class="main main-exercise">
        {{-- タイトル行（＋ボタンでモーダル） --}}
        <section class="exercise-top-row">
            <h2 class="exercise-title">種目</h2>
            <button type="button" class="exercise-add-btn">＋</button>
        </section>

        {{-- カテゴリタブ --}}
        <section class="exercise-section">
            <div class="exercise-tabs">
                <button class="exercise-tab is-active" data-category="胸">胸</button>
                <button class="exercise-tab" data-category="肩">肩</button>
                <button class="exercise-tab" data-category="腕">腕</button>
                <button class="exercise-tab" data-category="背中">背中</button>
                <button class="exercise-tab" data-category="脚">脚</button>
                <button class="exercise-tab" data-category="腹">腹</button>
                <button class="exercise-tab" data-category="有酸素">有酸素</button>
                <button class="exercise-tab" data-category="その他">その他</button>
            </div>
        </section>

        {{-- 種目リスト --}}
        <section class="exercise-section">
            <ul class="exercise-list">
                @foreach($exercises as $exercise)
                    <li class="exercise-item"
                        data-category="{{ $exercise->category }}">
                        <span class="exercise-color-bar"></span>
                        <span class="exercise-name">{{ $exercise->name }}</span>
                        <input type="hidden" class="exercise-id" value="{{ $exercise->id }}">
                    </li>
                @endforeach

                {{-- 絞り込み結果が0件のとき用の行 --}}
                <li class="exercise-item exercise-item-empty">
                    <span class="exercise-name">種目がありません</span>
                </li>
            </ul>
        </section>
    </main>

    {{-- 種目追加モーダル（ワークアウト画面と同じBootstrapテイスト） --}}
    <section>
        <div class="modal fade" id="exerciseModal" tabindex="-1" aria-labelledby="exerciseModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-2xl">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exerciseModalLabel">種目を追加</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                    </div>
                    <div class="modal-body">
                        <form id="exerciseForm" method="POST" action="#">
                            {{-- TODO: action は後で route('exercises.store') などに変更 --}}
                            @csrf
                            <div class="mb-3">
                                <label for="exercise-name-input" class="form-label">種目名</label>
                                <input
                                    id="exercise-name-input"
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    placeholder="例）ベンチプレス"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="exercise-category-select" class="form-label">部位</label>
                                <select
                                    id="exercise-category-select"
                                    name="category"
                                    class="form-select"
                                    required
                                >
                                    <option value="">選択してください</option>
                                    <option value="胸">胸</option>
                                    <option value="肩">肩</option>
                                    <option value="腕">腕</option>
                                    <option value="背中">背中</option>
                                    <option value="脚">脚</option>
                                    <option value="腹">腹</option>
                                    <option value="有酸素">有酸素</option>
                                    <option value="その他">その他</option>
                                </select>
                            </div>
                            <input type="hidden" id="exercise-id-select" name="id">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="exerciseSubmitButton" class="btn btn-primary w-100">
                            追加
                        </button>
                        <button id="exerciseDeleteButton" class="exercise-delete-btn">
                            削除
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

    <script src="{{ asset('js/lib/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('js/exercise.js') }}"></script>
</body>
</html>
