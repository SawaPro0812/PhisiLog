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
// ワークアウト登録画面
Route::get('/workouts/create', [WorkoutController::class, 'create'])->name('workouts.create');
// ワークアウト登録処理
Route::post('/workouts/store', [WorkoutController::class, 'store'])->name('workouts.store');

require __DIR__.'/auth.php';
