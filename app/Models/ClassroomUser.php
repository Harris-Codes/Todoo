<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassroomUser extends Pivot
{
    protected $table = 'classroom_user';
    protected $fillable = ['classroom_id', 'user_id', 'role'];
}
