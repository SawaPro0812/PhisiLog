<?php

namespace App\Services;

use App\Models\Exercise;

class ExerciseService
{
    public function __construct()
    {
        //
    }

    // ユーザのトレーニングメニューを取得する
    public function getAllByUser($userId) {
        $exercises = Exercise::where('user_id', $userId)->get();
        return $exercises;
    }

    // 種目を取得する
    public function getExercise($exerciseId) {
        $exercise = Exercise::where('id', $exerciseId)->first();
        return $exercise;
    }
}
