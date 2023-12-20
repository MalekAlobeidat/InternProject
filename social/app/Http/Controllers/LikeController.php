<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request)
    {
        $validatedData = $request->validate([
            'UserID' => 'required',
            'PostID' => 'required',
        ]);
        // Use ->where instead of ->andWhere
        $like = Like::where('UserID', $request->UserID)->where('PostID', $request->PostID)->get();
    
        if ($like->isNotEmpty()) {
            return response()->json(['message' => 'already liked'], 201);
        }
    
        // If the user has not already liked the post, you can create the like record
        $like = Like::create($validatedData);
    
        return response()->json(['like' => $like], 201);
    }

    public function unlike(Request $request)
    {
        $validatedData = $request->validate([
            'UserID' => 'required',
            'PostID' => 'required',
        ]);

        Like::where($validatedData)->delete();

        return response()->json(['message' => 'Post unliked successfully'], 200);
    }
}
