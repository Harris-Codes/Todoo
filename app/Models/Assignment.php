<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'classroom_id',
        'user_id',
        'title',
        'description',
        'due_date',
        'file_path',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
