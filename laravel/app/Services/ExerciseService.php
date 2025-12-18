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
    public function getExercise($param) {
        $exercise = UserExercise::where('id', $param['exerciseId'])->where('user_id', $param['userId'])->first();
        return $exercise;
    }

    // 種目を登録する
    public function createExercise($param) {
        $exercise = new UserExercise();
        $exercise->user_id = $param['userId'];
        $exercise->name = $param['name'];
        $exercise->category = $param['category'];
        $exercise->save();
        return $exercise;
    }

    // 種目を更新する
    public function updateExercise($param) {
        // 自分の種目かチェック
        $exercise = UserExercise::where('id', $param['id'])
            ->where('user_id', $param['userId'])
            ->first();
        
        if (!$exercise) {
            return null;
        }

        $exercise->name = $param['name'];
        $exercise->category = $param['category'];
        $exercise->save();
        return $exercise;
    }

    // 種目を削除する
    public function deleteExercise($param) {
        // 自分の種目かチェック
        $exercise = UserExercise::where('id', $param['id'])
            ->where('user_id', $param['userId'])
            ->first();

        if (!$exercise) {
            return null;
        }

        $exercise->delete();

        return $param['id'];
    }
}
