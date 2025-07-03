<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'teacher_id',
        'code',
        'background_image'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function posts()
    {

        return $this->hasMany(Post::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function folders()
    {
        return $this->hasMany(Folder::class);
    }



    public function students()
    {
        return $this->belongsToMany(User::class)
            ->using(ClassroomUser::class) // <- This line tells Laravel to use your pivot model
            ->withPivot('role')           // optional: include extra pivot columns
            ->withTimestamps();
    }

    public function badges()
    {
        return $this->hasMany(Badge::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
