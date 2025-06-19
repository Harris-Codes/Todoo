<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Classroom;
use App\Models\ClassroomUser;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // For Teachers: Classrooms they created.
    public function classesCreated()
    {
        return $this->hasMany(Classroom::class, 'teacher_id');
    }

    public function getProfilePictureUrlAttribute()
    {
        return $this->profile_picture 
            ? asset('storage/' . $this->profile_picture)
            : asset('images/default-profile.png'); // fallback image
    }


    // For students: classroom they joined
    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_user')
                    ->using(\App\Models\ClassroomUser::class) // only if you use a custom pivot model
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function joinedClassrooms()
    {
        return $this->belongsToMany(Classroom::class)
                    ->using(ClassroomUser::class)
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function classesJoined()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_user', 'user_id', 'classroom_id')
                    ->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function submissions() {
        return $this->hasMany(Submission::class, 'student_id');
    }
    
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'badge_user')->withTimestamps();
    }



}
