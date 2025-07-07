<?php

namespace App\Models;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'title',
        'difficulty_level_id',
        'description',
        'order',
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function difficultyLevel()
    {
        return $this->belongsTo(DifficultyLevel::class);
    }
}
