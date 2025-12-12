<?php

namespace App\Services;

class CommonService
{
    protected $exerciseService;

    public function __construct(
        ExerciseService $exerciseService,
        WorkoutService $workoutService,
    )
    {
        $this->exerciseService = $exerciseService;
        $this->workoutService = $workoutService;
    }
    
    // トップ画面のデータ取得
    public function getTopData($userId)
    {
        return [
            //'user' => $this->userService->getProfile($userId),
            'exercises' => $this->exerciseService->getAllByUser($userId),
            //'workouts' => $this->workoutService->getRecentByUser($userId),
        ];
    }

    // ワークアウト登録画面のデータ取得
    public function getCreateData($exerciseId)
    {
        return $this->exerciseService->getExercise($exerciseId);
    }

    // ワークアウト登録処理
    public function createWorkout($data)
    {
        $this->workoutService->createWorkout($data);
        return;
    }

    // ワークアウト履歴取得（日付）
    public function getByDate($param) {
        return $this->workoutService->getByDate($param);
    }

    // ワークアウト編集画面のデータ取得
    public function getWorkoutData($param)
    {
        return $this->workoutService->getWorkoutData($param);
    }

    // 種目取得
    public function getExercise($param)
    {
        return $this->workoutService->getWorkoutData($param);
    }

    // ワークアウト編集処理
    public function updateWorkout($data)
    {
        $this->workoutService->updateWorkout($data);
        return;
    }

    // 種目取得（ユーザに紐づく）
    public function getExerciseByUser($userId)
    {
        return $this->exerciseService->getAllByUser($userId);
    }

    // 種目登録（ユーザに紐づく）
    public function createExercise($param)
    {
        return $this->exerciseService->createExercise($param);
    }

    // 種目更新
    public function updateExercise($param)
    {
        return $this->exerciseService->updateExercise($param);
    }

    // 種目削除
    public function deleteExercise($param)
    {
        return $this->exerciseService->deleteExercise($param);
    }
}
