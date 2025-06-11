<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id', 
            'comment_text' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->check() ? auth()->id() : (auth('teacher')->check() ? auth('teacher')->id() : null),
            'comment_text' => $request->comment_text,
        ]);
    
        return redirect()->back()->with('success', 'Comment posted!');
    
    }

   
}
