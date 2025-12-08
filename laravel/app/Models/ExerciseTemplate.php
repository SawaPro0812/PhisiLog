<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseTemplate extends Model
{
    protected $table = 'exercise_templates';

    protected $fillable = [
        'name',
        'category',
    ];
}
