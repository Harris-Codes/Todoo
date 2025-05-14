<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\User;

class TeacherClassroomController
{
    
    public function show($id)
    {
        $classroom = Classroom::with([
            'assignments',
            'posts.user', 
            'files',
            'students',
            'teacher'
        ])->findOrFail($id);

        return view('teacher-classroom', compact('classroom'));
    }

    

}
