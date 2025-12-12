<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\ExerciseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// トップメニュー画面
Route::get('/workouts/top', [WorkoutController::class, 'index'])->middleware(['auth'])->name('workouts.index');
// ワークアウト履歴取得
Route::get('/workouts/by-date', [WorkoutController::class, 'getByDate'])->name('workouts.getByDate');
// ワークアウト登録画面
Route::get('/workouts/create', [WorkoutController::class, 'create'])->name('workouts.create');
// ワークアウト登録処理
Route::post('/workouts/store', [WorkoutController::class, 'store'])->name('workouts.store');
// ワークアウト編集画面
Route::get('/workouts/edit', [WorkoutController::class, 'edit'])->name('workouts.edit');
// ワークアウト更新処理
Route::post('/workouts/update', [WorkoutController::class, 'update'])->name('workouts.update');

// 種目登録画面
Route::get('/exercises/create', [ExerciseController::class, 'create'])->name('exercises.create');
// 種目登録処理
Route::post('/exercises/store', [ExerciseController::class, 'store'])->name('exercises.store');
// 種目更新処理
Route::post('/exercises/update', [ExerciseController::class, 'update'])->name('exercises.update');
// 種目削除処理
Route::post('/exercises/delete', [ExerciseController::class, 'delete'])->name('exercises.delete');


require __DIR__.'/auth.php';
