<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function getLikes()
    {
        $posts = Post::all();

        $likeData = [];

        foreach ($posts as $post) {
            $postId = $post->PostID;
            $likeCount = Like::where('PostID', $postId)->count();

            $likeData[$postId] = $likeCount;
        }

        if (empty($likeData)) {
            return response()->json('No likes here.');
        }

        return response()->json($likeData);
    }

    public function getComments()
    {
        $posts = Post::all();

        $commentData = [];

        foreach ($posts as $post) {
            $postId = $post->PostID;
            $commentCount = Comment::where('PostID', $postId)->count();

            $commentData[$postId] = $commentCount;
        }

        if (empty($commentData)) {
            return response()->json('No comments here.');
        }

        return response()->json($commentData);
    }
    public function analyticsReport()
    {
        $totalPosts = Post::count();
        $totalLikes = Like::count();
        $totalComments = Comment::count();

        $highestLikesPost = Post::withCount('likes')->orderBy('likes_count', 'desc')->first();
        $highestCommentsPost = Post::withCount('comments')->orderBy('comments_count', 'desc')->first();
        $lowestCommentsPost = Post::withCount('comments')->orderBy('comments_count', 'asc')->first();
        $lowestLikedPost = Post::withCount('likes')->orderBy('likes_count', 'asc')->first();

        $topTenAccounts = Post::join('likes', 'posts.PostID', '=', 'likes.PostID')
            ->select('posts.UserID')
            ->selectRaw('COUNT(*) AS likes_count')
            ->groupBy('posts.UserID')
            ->orderBy('likes_count', 'desc')
            ->limit(10)
            ->get();

        // Calculate the number of new users this month
        $newUsersThisMonth = User::whereMonth('created_at', '=', date('m'))->count();

        // Calculate the number of users in the last week
        $usersInLastWeek = User::where('created_at', '>=', now()->subWeek())->count();

        $analyticsData = [
            'totalPosts' => $totalPosts,
            'totalLikes' => $totalLikes,
            'totalComments' => $totalComments,
            'highestLikesPost' => $highestLikesPost,
            'highestCommentsPost' => $highestCommentsPost,
            'lowestCommentsPost' => $lowestCommentsPost,
            'lowestLikedPost' => $lowestLikedPost,
            'topTenAccounts' => $topTenAccounts,
            'newUsersThisMonth' => $newUsersThisMonth,
            'usersInLastWeek' => $usersInLastWeek,
        ];

        return response()->json($analyticsData);
    }
}
