<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedbacks'; 
    protected $fillable = ['teacher_id', 'student_id', 'classroom_id', 'message'];

    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
}
