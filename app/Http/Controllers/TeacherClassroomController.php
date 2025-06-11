<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class TeacherClassroomController
{
    
    public function show($id)
    {
        $classroom = Classroom::with([
            'assignments',
            'posts.user', 
            'posts.comments.user',
            'files',
            'students',
            'teacher',
            'posts.quiz.questions' 
        ])->findOrFail($id);

        foreach ($classroom->posts as $post) {
            if ($post->quiz && $post->quiz->relationLoaded('questions')) {
                $post->quiz->calculated_points = $post->quiz->questions->sum('points');
                $post->quiz->calculated_time = $post->quiz->questions->sum('time');
            }
        }

        return view('teacher-classroom', compact('classroom'));
    }

    
    //Adding student to the classroom
    public function addStudent(Request $request, $classroomId){
        
        //make sure to validate the email
        $request->validate([
            'email'=>'required|email'
        ]);

        $user = User::where('email',$request->email)->first();

        //if not a user show this:
        if(!$user){

            return back()->with('error','User with this email does not exist.');

        }

        $classroom = Classroom::findOrFail($classroomId);

        // Check if user already added
        if ($classroom->students()->where('user_id', $user->id)->exists()) {

            return back()->with('error','Student already in this classroom.');
        }
        
        // Attach student to classroom
        $classroom->students()->attach($user->id, ['role' => 'student']);

        return back()->with('success','Student added successfully.');

    }


    // Remove students from the tab
    public function removeStudent($classroomId,$studentId){

        $classroom = Classroom::findOrFail($classroomId);
        $classroom->students()->detach($studentId);

        return back()->with('Success', 'Student removed');
    }
    

}
