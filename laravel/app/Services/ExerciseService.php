<?php

namespace App\Services;

use App\Models\UserExercise;

class ExerciseService
{
    public function __construct()
    {
        //
    }

    // ユーザのトレーニングメニューを取得する
    public function getAllByUser($userId) {
        $exercises = UserExercise::where('user_id', $userId)->get();
        return $exercises;
    }

    // 種目を取得する
    public function getExercise($exerciseId) {
        $exercise = UserExercise::where('id', $exerciseId)->first();
        return $exercise;
    }
}
