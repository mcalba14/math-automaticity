<?php

namespace App\Models;

use App\Models\Lesson;
use App\Models\DifficultyLevel;
use App\Models\StudentActivityAttempt;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'lesson_id',
        'difficulty_level_id',
        'question_text',
        'choices',
        'answer',
        'type',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'choices' => 'array',
        ];
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function difficultyLevel()
    {
        return $this->belongsTo(DifficultyLevel::class);
    }

    public function attempts()
    {
        return $this->hasMany(StudentActivityAttempt::class);
    }
}
