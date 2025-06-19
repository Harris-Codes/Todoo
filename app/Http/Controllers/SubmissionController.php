<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Services\BadgeEvaluationService;
use App\Models\Assignment;

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

        
        // ❌ Prevent resubmission if already graded
        if ($existing && $existing->grade !== null) {
            return back()->with('error', 'You cannot resubmit after your assignment has been graded.');
        }

        // Store new file
        $uploadedFile = $request->file('submission_file');
        $originalName = $uploadedFile->getClientOriginalName();
        $path = $uploadedFile->store('submissions', 'public');

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
                'original_filename' => $originalName,
                'submitted_at' => now()
            ]
        );

        // Evaluate badge conditions
        $assignment = Assignment::find($assignmentId);
        BadgeEvaluationService::evaluate($studentId, $assignment->classroom_id);



        return back()->with('success', 'Assignment submitted successfully!');
    }

    public function getByAssignment($id)
    {
        $submissions = Submission::where('assignment_id', $id)
            ->with('student') // Assuming 'student' is the relation to User
            ->get()
            ->map(function ($submission) {
                return [
                    'id' => $submission->id,
                    'student_name' => $submission->student->name,
                    'file_path' => $submission->file_path,
                    'original_filename' => basename($submission->file_path),
                    'grade' => $submission->grade, 
                    'profile_picture' => $submission->student->profile_picture,
                    ];
            });

        return response()->json($submissions);
    }

    public function grade(Request $request, $id)
    {
        $request->validate([
            'grade' => 'required|in:A,B,C,D'
        ]);

        $submission = Submission::findOrFail($id);
        $submission->grade = $request->grade;
        $submission->save();

        return response()->json(['success' => true]);
    }


    public function resetGrade($id)
    {
        $submission = Submission::findOrFail($id);
        $submission->grade = null;
        $submission->save();

        return response()->json(['success' => true]);
    }
}
