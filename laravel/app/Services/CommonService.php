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
}
