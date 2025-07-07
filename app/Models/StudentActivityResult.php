<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentActivityResult extends Model
{
    protected $fillable = [
        'attempt_id',
        'questions_taken',
        'total_correct',
        'score',
    ];

    /**
     * Get the student activity attempt associated with the result.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function studentActivityAttempt()
    {
        return $this->hasMany(StudentActivityAttempt::class);
    }
}
