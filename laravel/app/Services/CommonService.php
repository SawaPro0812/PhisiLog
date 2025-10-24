<?php

namespace App\Services;

class CommonService
{
    protected $exerciseService;

    public function __construct(
        ExerciseService $exerciseService,
    )
    {
        $this->exerciseService = $exerciseService;
    }
    
    public function getTopData($userId)
    {
        return [
            //'user' => $this->userService->getProfile($userId),
            'exercises' => $this->exerciseService->getAllByUser($userId),
            //'workouts' => $this->workoutService->getRecentByUser($userId),
        ];
    }
}
