<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserExercise extends Model
{
    protected $table = 'user_exercises';

    protected $fillable = [
        'user_id',
        'name',
        'category',
    ];
}
