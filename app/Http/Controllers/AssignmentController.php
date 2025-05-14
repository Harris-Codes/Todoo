<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;

class AssignmentController
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:2048'
        ]);

        


        $path = null;

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('assignments', 'public');
        }

        Assignment::create([
            'classroom_id' => $validated['classroom_id'],
            'title' => $validated['title'],
            'user_id'=> Auth::id(), //Add the currently logged in user (Teacher)
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'file_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Assignment created.');
    }


    public function update(Request $request, Assignment $assignment)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'description' => 'required|string',
            'file' => 'nullable|file|max:2048'
        ]);

        $data = $request->only('title', 'due_date', 'description');

       
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments', 'public');
            $data['file_path'] = $filePath;
        }

        $assignment->update($data);

        return redirect()->back()->with('success', 'Assignment updated.');
    }



    
    
    public function destroy(Assignment $assignment)
    {
      
        $assignment->delete();

        return redirect()->back()->with('success', 'Assignment deleted.');
    }


}
