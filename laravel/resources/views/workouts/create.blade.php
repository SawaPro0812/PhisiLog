{{-- resources/views/workouts/create.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Physilog - ワークアウト登録</title>
    <link rel="stylesheet" href="{{ asset('css/workout_create.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
</head>
<body>
    <header class="header">
        <a href="{{ route('workouts.index', ['date' => request('date')]) }}" class="back-btn">&lt;</a>
        <h1>Physilog</h1>
        <span></span>
    </header>

    <main class="main">
        <section class="set-section">
            <h2>{{ $data['exercise']->name }}</h2>

            @include('workouts._form', [
                'mode' => 'create',
                'data' => $data,
            ])
        </section>
    </main>

    <script src="{{ asset('js/lib/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/workout_create.js') }}"></script>
</body>
</html>
