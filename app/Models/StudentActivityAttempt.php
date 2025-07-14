<?php

namespace App\Models;

use App\Models\Lesson;
use App\Models\StudentActivityResult;
use Illuminate\Database\Eloquent\Model;

class StudentActivityAttempt extends Model
{
    protected $fillable = [
        'attempt_id',
        'student_id',
        'lesson_id',
        'activity_id',
        'student_answer',
        'is_correct',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function activityResult()
    {
        return $this->belongsTo(StudentActivityResult::class);
    }
}
