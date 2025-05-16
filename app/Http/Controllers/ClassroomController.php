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
    
    
    
    
}
