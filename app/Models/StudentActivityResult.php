<?php

namespace App\Models;

use App\Models\Lesson;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class StudentActivityResult extends Model
{
    protected $fillable = [
        'attempt_id',
        'student_id', // Added student_id to track which student the result belongs to
        'lesson_id', // Added lesson_id to track which lesson the result belongs to
        'questions_taken',
        'total_correct',
        'score',
        'accuracy', // Percentage of correct answers in the activity
    ];

    /**
     * Get the student activity attempt associated with the result.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function studentActivityAttempt()
    {
        return $this->hasMany(StudentActivityAttempt::class, 'attempt_id', 'attempt_id');
    }
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
