<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'classroom_id',
    ];

    /**
     * Each folder belongs to a classroom.
     */
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * A folder can have many files.
     */
    public function files()
    {
        return $this->hasMany(\App\Models\File::class);
    }
}
