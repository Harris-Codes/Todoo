<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'classroom_id',
        'name',
        'type',
        'condition_value',
        'image',
    ];

    // A badge belongs to one classroom
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    // Optional: if you make a pivot for which users earned which badge
    public function awardedToUsers()
    {
        return $this->belongsToMany(User::class, 'badge_user')->withTimestamps();
    }

    
}
