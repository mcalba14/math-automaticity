<?php

namespace App\Models;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;

class DifficultyLevel extends Model
{
    protected $fillable = [
        'name',
        'time_limit',
        'description',
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
