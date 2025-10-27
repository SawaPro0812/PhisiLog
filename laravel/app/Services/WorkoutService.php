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

    // ワークアウト履歴を取得する
    public function getByDate($param) {
        $workouts = $this->workout->getByDate($param);
        $grouped = $workouts->groupBy('exercise_id')
            ->map(function ($items) {
                $exerciseName = optional($items->first()->exercise)->name ?? '不明';
                $setCount = $items->count();
                $totalWeight = $items->sum(fn($w) => $w->weight * $w->reps);

                return [
                    'exercise_id' => $items->first()->exercise_id,
                    'exercise_name' => $exerciseName,
                    'sets' => $setCount,
                    'total_weight' => $totalWeight,
                ];
            });
        return $grouped->values();
    }
}
