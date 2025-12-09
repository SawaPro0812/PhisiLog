<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutController;
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
Route::get('/workouts/top', [WorkoutController::class, 'index'])->name('workouts.index');
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

require __DIR__.'/auth.php';
