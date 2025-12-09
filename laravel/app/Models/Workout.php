<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $table = 'workouts';

    protected $fillable = [
        'user_id',
        'name',
        'exercise_id',
        'weight',
        'reps',
        'date',
        'memo'
    ];

    public function userExercise() {
        return $this->belongsTo(UserExercise::class, 'exercise_id');
    }

    public function getByDate($param) {
        return Workout::with('userExercise')
            ->where('user_id', $param['userId'])
            ->whereDate('date', $param['date'])
            ->orderBy('exercise_id')
            ->get();
    }

    public function getWorkoutByUserAndDate($param) {
        return Workout::with('userExercise')
            ->where('user_id', $param['userId'])
            ->whereDate('date', $param['date'])
            ->where('exercise_id', $param['exerciseId'])
            ->orderBy('exercise_id')
            ->get();
    }
}
