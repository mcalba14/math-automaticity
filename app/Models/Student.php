<?php

namespace App\Models;

use App\Models\User;
use App\Models\StudentActivityAttempt;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
    ];

    /**
     * Get the user associated with the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activityAttempts()
    {
        return $this->hasMany(StudentActivityAttempt::class);
    }
}
