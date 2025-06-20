<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

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
    
    
}
