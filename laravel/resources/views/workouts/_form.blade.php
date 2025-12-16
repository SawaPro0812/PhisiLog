{{-- resources/views/workouts/_form.blade.php --}}
@php
    $mode   = $mode ?? 'create';
    $isEdit = $mode === 'edit';
@endphp

<form id="workoutForm"
      method="POST"
      action="{{ $isEdit ? route('workouts.update') : route('workouts.store') }}">
    @csrf

    <input type="hidden" name="date" value="{{ $data['date'] ?? '' }}">
    <input type="hidden" name="exercise_id" value="{{ $data['exercise']->id ?? '' }}">

    <div>
        {{ isset($data['date']) ? \Carbon\Carbon::parse($data['date'])->format('Y年m月d日') : '' }}
    </div>

    <div id="set-list">
        @if($isEdit)
            @forelse($data['workout'] as $index => $workout)
                <div class="set-row">
                    <label class="set-label">セット {{ $loop->iteration }}</label>

                    {{-- 更新用にこのセットのレコードIDを hidden で持っておく --}}
                    <input type="hidden"
                           name="sets[{{ $index }}][id]"
                           value="{{ $workout->id }}">

                    <input type="number"
                           step="0.01"
                           name="sets[{{ $index }}][weight]"
                           class="input-weight"
                           placeholder="重量"
                           value="{{ old("sets.$index.weight", $workout->weight) }}"
                           inputmode="decimal"
                           pattern="[0-9]*"
                           required> kg

                    <input type="number"
                           name="sets[{{ $index }}][reps]"
                           class="input-reps"
                           placeholder="回数"
                           value="{{ old("sets.$index.reps", $workout->reps) }}"
                           inputmode="decimal"
                           pattern="[0-9]*"
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
        @else
            {{-- 新規登録時：元の仕様どおり 3 セット分の空フォーム --}}
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
        @endif
    </div>

    <div class="set-controls">
        <button type="button" id="addSet" class="set-btn plus">＋</button>
        <button type="button" id="removeSet" class="set-btn minus">－</button>
    </div>

    <div class="memo-section">
        <label for="memo">メモ</label>
        <textarea name="memo" id="memo" rows="3" placeholder="メモを入力...">{{ $data['memo'] }}</textarea>
    </div>

    <div class="submit-area">
        <button type="submit" class="submit-btn">登録</button>
    </div>
</form>
