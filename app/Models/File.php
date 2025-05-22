<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'classroom_id',
        'folder_id',
        'uploaded_by',
        'file_name',
        'file_path'
    ];
    
    
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function uploader()
    {
        return $this->belongsTo(\App\Models\User::class, 'uploaded_by');
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

}
