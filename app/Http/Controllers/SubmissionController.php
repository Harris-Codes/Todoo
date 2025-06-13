<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
class SubmissionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'submission_file' => 'required|file|max:5120', // max 5MB
        ]);

        $studentId = auth()->id();
        $assignmentId = $request->assignment_id;

        // Check for existing submission
        $existing = Submission::where('assignment_id', $assignmentId)
                    ->where('student_id', $studentId)
                    ->first();

        // Store new file
        $path = $request->file('submission_file')->store('submissions', 'public');

        // Delete old file if submission exists
        if ($existing && $existing->file_path && Storage::disk('public')->exists($existing->file_path)) {
            Storage::disk('public')->delete($existing->file_path);
        }

        // Save new or updated submission
        Submission::updateOrCreate(
            [
                'assignment_id' => $assignmentId,
                'student_id' => $studentId
            ],
            [
                'file_path' => $path,
                'submitted_at' => now()
            ]
        );

        return back()->with('success', 'Assignment submitted successfully!');
    }
}
