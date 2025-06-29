<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Post;
use App\Models\Classroom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Session;
use App\Services\BadgeEvaluationService;


class QuizController extends Controller
{   
    public function show($classroomId, $quizId)
    {
        $classroom = Classroom::findOrFail($classroomId);
        $quiz = Quiz::with('questions.answers')->findOrFail($quizId);
    
        // 🔒 Block if student is not in the class
        if (!$classroom->students()->where('user_id', auth()->id())->exists()) {
            abort(403, 'You are not part of this classroom');
        }
    
        // 🔒 Block if already attempted
        $alreadyAttempted = QuizAttempt::where('quiz_id', $quiz->id)
                                       ->where('user_id', auth()->id())
                                       ->exists();
    
        if ($alreadyAttempted) {
            return redirect()->route('student.classroom', $classroomId)
                             ->with('error', 'You have already attempted this quiz.');
        }
    
        // 🧠 Prepare quiz data
        $quizData = [
            'title' => $quiz->title,
            'questions' => $quiz->questions->map(function ($question) {
                return [
                    'text' => $question->question_text,
                    'options' => $question->answers->pluck('answer_text')->toArray(),
                    'correct' => $question->answers->search(fn($a) => $a->is_correct),
                    'points' => $question->points ?? 0,
                    'time' => $question->time ?? 30,
                ];
            }),
        ];
    
        return view('quiz', [
            'classroom' => $classroom,
            'quizData' => $quizData,
            'quiz' => $quiz,
        ]);
        
    }

    public function overview(Request $request)
    {
        $teacherId = auth()->id();
        $classroomId = $request->input('classroom_id');
    
        $classrooms = Classroom::where('teacher_id', $teacherId)->get();
    
        $quizzes = Quiz::with('classroom')
            ->when($classroomId, function ($query) use ($classroomId) {
                $query->where('classroom_id', $classroomId);
            })
            ->whereIn('classroom_id', $classrooms->pluck('id'))
            ->orderByDesc('created_at')
            ->get();
    
        return view('quiz-overview', [
            'quizzes' => $quizzes,
            'teacherClassrooms' => $classrooms,
        ]);
            
    }
    
    

    public function showCreateQuiz($classroom_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);

        

        if ($classroom->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('create-quiz', compact('classroom'));
    }


    public function store(Request $request)
    {
        $data = $request->json()->all();
        $request->merge($data);

        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'title' => 'required|string|max:255',
            'timer_seconds' => 'nullable|integer',
            'total_points' => 'nullable|integer',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string',
            'questions.*.slide_note' => 'nullable|string',
            'questions.*.points' => 'nullable|integer',
            'questions.*.time' => 'nullable|integer',
            'questions.*.answers' => 'required|array|min:1',
            'questions.*.answers.*.text' => 'required|string',
            'questions.*.answers.*.is_correct' => 'boolean',
        ]);

        DB::beginTransaction();

        try {
            $quiz = Quiz::create([
                'classroom_id' => $request->classroom_id,
                'user_id' => auth()->id(),
                'title' => $request->title,
                'timer_seconds' => $request->timer_seconds,
                'total_points' => $request->total_points,
            ]);

            foreach ($request->questions as $qData) {
                $question = $quiz->questions()->create([
                    'question_text' => $qData['text'],
                    'slide_note' => $qData['slide_note'] ?? null,
                    'points' => $qData['points'] ?? 0,
                    'time' => $qData['time'] ?? 0,
                ]);

                foreach ($qData['answers'] as $aData) {
                    $question->answers()->create([
                        'answer_text' => $aData['text'],
                        'is_correct' => $aData['is_correct'] ?? false,
                    ]);
                }
            }

            Post::create([
                'classroom_id' => $quiz->classroom_id,
                'user_id' => auth()->id(),
                'content' => '📘 New Quiz: ' . $quiz->title,
                'quiz_id' => $quiz->id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Quiz created successfully',
                'quiz_id' => $quiz->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quiz creation failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Server error while creating quiz.'
            ], 500);
        }
    }

    public function update(Request $request, Quiz $quiz)
    {
        $data = $request->json()->all();
        $request->merge($data); // For validation

        $request->validate([
            'title' => 'required|string|max:255',
            'timer_seconds' => 'nullable|integer',
            'total_points' => 'nullable|integer',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string',
            'questions.*.slide_note' => 'nullable|string',
            'questions.*.points' => 'nullable|integer',
            'questions.*.time' => 'nullable|integer',
            'questions.*.answers' => 'required|array|min:1',
            'questions.*.answers.*.text' => 'required|string',
            'questions.*.answers.*.is_correct' => 'boolean',
        ]);

        $quiz->update([
            'title' => $request->title,
            'timer_seconds' => $request->timer_seconds,
            'total_points' => $request->total_points,
        ]);

        // Clear old questions/answers
        foreach ($quiz->questions as $question) {
            $question->answers()->delete();
            $question->delete();
        }

        // Re-create new questions and answers
        foreach ($request->questions as $qData) {
            $question = $quiz->questions()->create([
                'question_text' => $qData['text'],
                'slide_note' => $qData['slide_note'] ?? null,
                'points' => $qData['points'] ?? 0,
                'time' => $qData['time'] ?? 0,
            ]);

            foreach ($qData['answers'] as $aData) {
                $question->answers()->create([
                    'answer_text' => $aData['text'],
                    'is_correct' => $aData['is_correct'] ?? false,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Quiz updated successfully',
            'quiz_id' => $quiz->id
        ]);
    }

    public function manage($quizId)
    {
        $quiz = Quiz::with('classroom', 'attempts.user')->findOrFail($quizId);

        // Authorization check
        if ($quiz->classroom->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('quiz-manage', ['quiz' => $quiz]);

    }

    public function viewResults($quiz_id)
    {
        $quiz = Quiz::with(['classroom', 'attempts.user'])->findOrFail($quiz_id);

        // Authorization check
        if ($quiz->classroom->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('teacher.quiz-results', compact('quiz'));
    }



    public function publish(Quiz $quiz)
    {
         
  
            if ($quiz->classroom->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

   
        if (!$quiz->is_published) {
            $quiz->is_published = true;
            $quiz->save();
    
            
            
        }
    
        return redirect()->back()->with('success', 'Quiz results have been published successfully.');
    }
    




    public function edit($classroom_id, $quiz_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
       
        
        if ($classroom->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $quiz = Quiz::with('questions.answers')->findOrFail($quiz_id);

        $transformedQuestions = $quiz->questions->map(function ($q) {
            return [
                'title' => $q->question_text,
                'slideNote' => $q->slide_note,
                'points' => $q->points,
                'time' => $q->time,
                'answers' => $q->answers->pluck('answer_text')->toArray(),
                'correctAnswers' => $q->answers->pluck('is_correct')->toArray()
            ];
        })->values();

        return view('create-quiz', compact('classroom', 'quiz', 'transformedQuestions'));
    }


    public function destroy(Quiz $quiz)
    {
      
        if ($quiz->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        try {
            // Delete related data
            foreach ($quiz->questions as $question) {
                $question->answers()->delete();
                $question->delete();
            }

            Post::where('quiz_id', $quiz->id)->delete();

            $quiz->delete();

            return redirect()->route('quiz.overview')->with('success', 'Quiz deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting quiz: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete quiz. Please try again.');
        }
    }


    public function submitAttempt(Request $request, $quizId)
    {
        $data = $request->json()->all(); 
        $request->merge($data);
        $request->validate([
            'score' => 'required|integer',
        ]);
    
        $quiz = Quiz::findOrFail($quizId);
    
        $existing = QuizAttempt::where('quiz_id', $quiz->id)
                    ->where('user_id', auth()->id())
                    ->first();
    
        if ($existing) {
            return response()->json(['message' => 'You have already attempted this quiz.'], 409);
        }
    
        $studentId = auth()->id();
        $classroomId = $quiz->classroom_id;
    
        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => $studentId,
            'score' => $request->score,
        ]);
    
       
        BadgeEvaluationService::evaluate($studentId, $classroomId);
    
        return response()->json(['message' => 'Quiz submitted successfully.']);
    }
    
    
    
    
    public function leaderboard($id)
    {
        $quiz = \App\Models\Quiz::with(['attempts.user'])->findOrFail($id);
    
        $rankedAttempts = $quiz->attempts
            ->sort(function ($a, $b) {
                if ($b->score === $a->score) {
                    return strtotime($a->created_at) <=> strtotime($b->created_at); // earlier = higher rank
                }
                return $b->score <=> $a->score; // higher score = higher rank
            })
            ->values(); // reindex to start at 0
    
        return response()->json($rankedAttempts);
    }
    
}