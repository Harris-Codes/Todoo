<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'message' => 'required|string|max:1000',
        ]);

        Feedback::create([
            'teacher_id' => Auth::id(),
            'student_id' => $request->student_id,
            'classroom_id' => $request->classroom_id,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Feedback added successfully!');
    }

    public function index($studentId)
    {
        $feedbacks = Feedback::where('student_id', $studentId)->latest()->get();
        return view('teacher.feedback.index', compact('feedbacks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $feedback = Feedback::findOrFail($id);

        // Optional: Only allow teacher who wrote it to update
        if ($feedback->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $feedback->message = $request->message;
        $feedback->save();

        return back()->with('success', 'Feedback updated successfully!');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);

        // Optional: Only allow teacher who wrote it to delete
        if ($feedback->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $feedback->delete();

        return back()->with('success', 'Feedback deleted successfully!');
    }
}
