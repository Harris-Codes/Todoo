<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class PostController extends Controller
{
    public function store (Request $request)
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
}
