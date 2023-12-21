<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log; // Add this line
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Friend;

use App\Models\FriendRequest;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    // ... (other methods)


   /**
     * Check if two users are friends.
     *
     * @param int $userId1
     * @param int $userId2
     * @return \Illuminate\Http\JsonResponse
     */

    public function areFriends($userId1, $userId2)
    {
        try {
            // Check if there is a friend request where user1 sent to user2 and it's accepted
            $friendRequest1 = FriendRequest::where([
                'SenderUserID' => $userId1,
                'ReceiverUserID' => $userId2,
                'Status' => 'accepted',
            ])->exists();

            // Check if there is a friend request where user2 sent to user1 and it's accepted
            $friendRequest2 = FriendRequest::where([
                'SenderUserID' => $userId2,
                'ReceiverUserID' => $userId1,
                'Status' => 'accepted',
            ])->exists();

            // If either friend request exists and is accepted, users are friends
            if ($friendRequest1 || $friendRequest2) {
                return response()->json(['success' => true, 'are_friends' => true]);
            } else {
                return response()->json(['success' => true, 'are_friends' => false]);
            }
        } catch (\Exception $e) {
            // Log additional information for debugging
            Log::error('Friend Request Query Error: ' . $e->getMessage());
            Log::info('User IDs: ' . $userId1 . ', ' . $userId2);

            // Handle case where an exception occurs (e.g., no query results)
            return response()->json([
                'success' => false,
                'message' => 'Error checking friend request status.',
                'exception_message' => $e->getMessage(),
            ]);
        }
    }



    // ... (other methods)
}
