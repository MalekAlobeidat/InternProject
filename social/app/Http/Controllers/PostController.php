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
            'Media' => 'required|nullable|file',
            'PrivacyID' => 'required',
        ]);

        try {
            $mediaPath = $request->file('Media')->store('media', 'public');
            $validatedData['Media'] ='http://127.0.0.1:8000/storage/' .$mediaPath;

            $post = Post::create($validatedData);

            return response()->json(['post' => $post], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'File upload failed'], 500);
        }
    }

    public function show(Post $post)
    {
        return response()->json(['post' => $post], 200);
    }

    public function update(Request $request, Post $post)
{
    $validatedData = $request->validate([
        'Content' => 'nullable|string',
        'Media' => 'nullable|file',
        'PrivacyID' => 'nullable',
    ]);

    if ($request->hasFile('Media')) {
        try {
            $mediaPath = $request->file('Media')->store('media', 'public');
            $validatedData['Media'] = 'http://127.0.0.1:8000/storage/' .$mediaPath;
        } catch (\Exception $e) {
            return response()->json(['error' => 'File upload failed'], 500);
        }
    }

    $post->update($validatedData);

    return response()->json(['post' => $post], 200);
}

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}