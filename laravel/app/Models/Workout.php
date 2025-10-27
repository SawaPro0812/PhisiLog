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

    public function exercise() {
        return $this->belongsTo(Exercise::class);
    }

    public function getByDate($param) {
        return Workout::with('exercise')
            ->where('user_id', $param['userId'])
            ->whereDate('date', $param['date'])
            ->orderBy('exercise_id')
            ->get();
    }
}
