<?php
// app/Http/Controllers/PostController.php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return response()->json(['posts' => $posts], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'UserID' => 'required',
            'Content' => 'nullable|string',
            'Media' => 'required|string',
            'PrivacyID' => 'required',
        ]);

        $post = Post::create($validatedData);

        return response()->json(['post' => $post], 201);
    }

    public function show(Post $post)
    {
        return response()->json(['post' => $post], 200);
    }

    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'Content' => 'nullable|string',
            'Media' => 'string',
            'PrivacyID' => 'nullable',
        ]);

        $post->update($validatedData);

        return response()->json(['post' => $post], 200);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}
