<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Post;
use App\Models\Classroom;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    public function showCreateQuiz($classroom_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
        return view('create-quiz', compact('classroom'));
    }



    public function store(Request $request)
    {
        // Convert JSON to array
        $data = $request->json()->all();

        // Merge into request so validator can access
        $request->merge($data);

        // Optional debug to confirm it's working
        Log::info('Incoming Quiz Data:', $data);

        // Validate input
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'title' => 'required|string|max:255',
            'timer_seconds' => 'nullable|integer',
            'total_points' => 'nullable|integer',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string',
            'questions.*.answers' => 'required|array|min:1',
            'questions.*.answers.*.text' => 'required|string',
            'questions.*.answers.*.is_correct' => 'boolean',
            'questions.*.slide_note' => 'nullable|string',
        ]);

        // Create the quiz
        $quiz = Quiz::create([
            'classroom_id' => $data['classroom_id'],
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'timer_seconds' => $data['timer_seconds'],
            'total_points' => $data['total_points']
        ]);

        // Loop through questions
        foreach ($data['questions'] as $q) {
            $question = $quiz->questions()->create([
                'question_text' => $q['text'],
                'slide_note' => $q['slide_note'] ?? null,
                'points' => $q['points'] ?? 0,
                'time' => $q['time'] ?? 0
            ]);

            foreach ($q['answers'] as $a) {
                $question->answers()->create([
                    'answer_text' => $a['text'],
                    'is_correct' => $a['is_correct'] ?? false
                ]);
            }
        }

        // Optional: create post
        Post::create([
            'classroom_id' => $quiz->classroom_id,
            'user_id' => auth()->id(),
            'content' => '📘 New Quiz: ' . $quiz->title,
            'quiz_id' => $quiz->id
        ]);

        return response()->json(['success' => true, 'quiz_id' => $quiz->id]);
    }

}
