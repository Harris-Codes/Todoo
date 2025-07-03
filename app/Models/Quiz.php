<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'classroom_id',
        'user_id',
        'timer_seconds',
        'total_points'
    ];

    public function classroom()
    {

        return $this->belongsTo(Classroom::class);
    }

    public function user()
    {

        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function post()
    {
        return $this->hasOne(Post::class);
    }

    public function getCalculatedPointsAttribute()
    {
        return $this->questions->sum('points'); // Sum actual 'points' field
    }

    public function getCalculatedTimeAttribute()
    {
        return $this->questions->sum('timer_seconds'); // Sum actual 'timer_seconds' field
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
