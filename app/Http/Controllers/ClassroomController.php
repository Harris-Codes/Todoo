<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use Illuminate\Support\Str;
class ClassroomController
{
    public function index()
    {
        $classes = auth()->user()->classesCreated; // only classes by logged-in teacher
        return view('teacher', compact('classes'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
        ]);

        Classroom::create([
            'subject' => $request->subject,
            'teacher_id' => auth()->id(),
            'code' => strtoupper(Str::random(6)), // it will generate 6 alphanumerical code
        ]);

        return response()->json(['message' => 'Classroom created successfully']);
    }

    public function destroy($id)
    {
        $class = Classroom::findOrFail($id);

        // Optional: Check if the current user owns this class
        if ($class->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $class->delete();

        return redirect()->back()->with('success', 'Classroom deleted successfully.');
    }

    public function show($id)
    {
        $classroom = Classroom::findOrFail($id);
    
        // Optional: Eager load relationships if needed (e.g., posts)
        return view('teacher-classroom', compact('classroom'));
    }
    //=========================== STUDENT ===============================

    public function studentClassroom($id)
    {
        $classroom = Classroom::with([
            'teacher',
            'assignments',
            'files.uploader',
            'folders.files.uploader', // ✅ Load folders AND their files
            'posts' => function ($query) {
                $query->latest(); // Order posts by newest first
            },
            'posts.user',
            'posts.comments.user'
        ])->findOrFail($id);
    
        // Optional: Check if student is enrolled
        if (!$classroom->students()->where('user_id', auth()->id())->exists()) {
            abort(403, 'Unauthorized access');
        }
    
        return view('classroom', compact('classroom'));
    }
    

    public function studentHomepage()
    {
        $joinedClasses = auth()->user()->classesJoined;
        return view('homepage', compact('joinedClasses'));
    }

    public function join(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6'
        ]);

        $classroom = Classroom::where('code', $request->code)->first();

        if (!$classroom) {
            return back()->withErrors(['code' => 'Invalid classroom code']);
        }

        // Avoid duplicate join
        $alreadyJoined = $classroom->students()->where('user_id', auth()->id())->exists();
        if ($alreadyJoined) {
            return back()->with('info', 'You already joined this classroom.');
        }

        // Attach student
        $classroom->students()->attach(auth()->id());

        return redirect()->route('student.homepage')->with('success', 'You have joined the classroom!');
    }

    //LEAVE CLASSROOM
    public function leave(Classroom $classroom)
    {
        $user = auth()->user();

        // Detach student
        $classroom->students()->detach($user->id);

        return redirect()->route('student.homepage')->with('success', 'You have left the classroom.');
    }

   


    
}
