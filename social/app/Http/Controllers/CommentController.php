<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        // You may implement this based on your requirements
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'UserID' => 'nullable', // Adjust validation rules as needed
            'PostID' => 'required',
            'CommentText' => 'required|string',
        ]);

        $comment = Comment::create($validatedData);

        return response()->json(['comment' => $comment], 201);
    }

    public function show(Comment $comment)
    {
        return response()->json(['comment' => $comment], 200);
    }

    public function update(Request $request, Comment $comment)
    {
        $validatedData = $request->validate([
            'CommentText' => 'required|string',
        ]);

        $comment->update($validatedData);

        return response()->json(['comment' => $comment], 200);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 200);
    }
}
