<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Badge;
use App\Models\Classroom;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class BadgeController extends Controller
{
    public function index(Request $request)
    {
        $teacherId = Auth::id();
        $classroomId = $request->input('classroom_id');
    
        $teacherClassrooms = Classroom::where('teacher_id', $teacherId)->get();
    
        $badges = collect(); // Empty collection by default
    
        if ($classroomId) {
            $badges = Badge::where('classroom_id', $classroomId)->orderBy('created_at', 'desc')->get();
        }
    
        return view('badges-overview', [
            'teacherClassrooms' => $teacherClassrooms,
            'badges' => $badges,
        ]);
    }
    
    
    public function store(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'classroom_id'     => 'required|exists:classrooms,id',
            'name'             => 'required|string|max:255',
            'type'             => 'required|in:submission_count,perfect_quiz,quiz_count,general_activity',
            'condition_value'  => 'required|integer|min:1',
            'image'            => 'required|string'  
        ]);
    
        try {
            
            // Attempt to create the badge
            Badge::create([
                'classroom_id'    => $validated['classroom_id'],
                'name'            => $validated['name'],
                'type'            => $validated['type'],
                'condition_value' => $validated['condition_value'],
                'image'           => $validated['image'],
            ]);
            
            return redirect()
                ->route('badges.overview', ['classroom_id' => $validated['classroom_id']])
                ->with('success', 'Badge created successfully!');
        }catch (\Exception $e) {
            Log::error('Badge creation failed: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create badge. Please try again.');
        }
        
    }
    
    
    

    public function overview(Request $request)
    {
        $teacherId = auth()->id();
        $teacherClassrooms = Classroom::where('teacher_id', $teacherId)->get();

        $classroomId = $request->get('classroom_id');
        $badges = [];

        if ($classroomId) {
            $badges = Badge::where('classroom_id', $classroomId)->get();
        }

        return view('badges-overview', compact('teacherClassrooms', 'badges'));
    }


    public function create($classroomId)
    {
        return view('badges-create', ['classroom_id' => $classroomId]);

    }
    
}
