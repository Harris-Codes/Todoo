<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['classroom_id', 'user_id', 'content', 'quiz_id'];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

}
