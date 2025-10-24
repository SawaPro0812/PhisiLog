<?php

namespace App\Services;

use App\Models\Workout;

class WorkoutService
{
    public function __construct(
        Workout $workout,
    )
    {
        $this->workout = $workout;
    }

    // ワークアウトを登録する
    public function createWorkout($data) {
        foreach ($data['sets'] as $set) {
            $workout = new Workout();
            $workout->user_id = $data['userId'];
            $workout->exercise_id = $data['exerciseId'];
            $workout->weight = $set['weight'];
            $workout->reps = $set['reps'];
            $workout->date = $data['date'];
            $workout->memo = $data['memo'];
            $workout->save();
        }
        
        return 'ok';
    }
}
