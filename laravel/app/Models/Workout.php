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
}
