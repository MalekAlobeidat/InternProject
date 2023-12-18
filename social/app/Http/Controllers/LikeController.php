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
