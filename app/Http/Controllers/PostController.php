<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Quiz;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'content' => 'required|string|max:1000'
        ]);

        Post::create([
            'classroom_id' => $request->classroom_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);


        return redirect()->back()->with('success', 'Post created successfully');
    }

    public function destroy(Post $post)
    {
        // Authorization check (optional)
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        DB::transaction(function () use ($post) {
            // If the post is linked to a quiz, delete the quiz and cascade its questions/answers
            if ($post->quiz_id) {
                $quiz = Quiz::with('questions.answers')->find($post->quiz_id);

                foreach ($quiz->questions as $question) {
                    $question->answers()->delete();
                    $question->delete();
                }

                $quiz->delete();
            }

            // Delete the post itself
            $post->delete();
        });

        return redirect()->back()->with('success', 'Post deleted.');
    }
}
