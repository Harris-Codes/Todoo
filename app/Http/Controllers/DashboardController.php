<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Models\Classroom;
use App\Models\Assignment;
use App\Models\Feedback;

class DashboardController extends Controller
{
    public function index()
    {
        //without this itll just show squiggle lines but it still works!
        /** @var \App\Models\User $user */
        $user = Auth::user();
    
        $classrooms = $user->classrooms()->with(['teacher', 'assignments', 'students'])->get();
        $badges = $user->badges()->latest()->take(6)->get(); // Or just ->take(6) if no timestamps
    
  
        $feedbacks = $user->receivedFeedback()->with('teacher')->latest()->get();

        return view('dashboard', compact('classrooms', 'badges', 'feedbacks'));
    }

    public function teacherDashboard()
    {
        $user = Auth::user();
    
        // ✅ Classrooms created by the logged-in teacher
        $classrooms = Classroom::where('teacher_id', $user->id)->with(['students', 'assignments', 'teacher'])->get();
    
       
        $teacherClassroomIds = Classroom::where('teacher_id', $user->id)->pluck('id');

        $recentAssignments = Assignment::whereIn('classroom_id', $teacherClassroomIds)
            ->with('classroom')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($a) {
                return (object) [
                    'message' => "You created assignment '{$a->title}' in {$a->classroom->subject}",
                    'created_at' => $a->created_at,
                ];
            });

            
        $recentFeedbacks = Feedback::where('teacher_id', $user->id)
            ->with('student')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($f) {
                return (object) [
                    'message' => "You gave feedback to {$f->student->name}",
                    'created_at' => $f->created_at,
                ];
            });
    
        // ✅ Combine and sort by date
        $activities = $recentAssignments->merge($recentFeedbacks)->sortByDesc('created_at')->values();
    
        return view('teacher-dashboard', [
            'classrooms' => $classrooms,
            'activities' => $activities,
        ]);
    }

    
    
}
