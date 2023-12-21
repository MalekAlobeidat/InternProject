<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum');
    // }
    public function friendRequestStatus($senderUserId, $receiverUserId)
    {
        $friendRequest = FriendRequest::where('SenderUserID', $senderUserId)
            ->where('ReceiverUserID', $receiverUserId)
            ->orWhere(function ($query) use ($senderUserId, $receiverUserId) {
                $query->where('SenderUserID', $receiverUserId)
                    ->where('ReceiverUserID', $senderUserId);
            })
            ->first();

        if (!$friendRequest) {
            // if they arent friends w/o any pending requests
            return response()->json('Add friend');
        }

        $Status = $friendRequest->Status;

        // Case if they are already friends
        if ($Status === 'accepted') {
            return response()->json('Friends');
        } elseif ($Status === 'pending' && $friendRequest->SenderUserID == $senderUserId) {
            // if they already sent a friend request
            // If the friend request is pending and the senderUserID matches the provided $senderUserId, return the appropriate response
            return response()->json('Waiting for their Approval');
        } else {
            // if the other person sent a friend request
            // If the friend request is pending and the senderUserID does not match the provided $senderUserId, return the appropriate response
            return response()->json('Respond to their request');
        }
    }
    public function add(Request $request)
    {
        $senderUserId = auth()->id();
        $receiverUserId = $request->input('ReceiverUserID');

        FriendRequest::create([
            'SenderUserID' => $senderUserId,
            'ReceiverUserID' => $receiverUserId,
            'Status' => 'pending',
        ]);

        return response()->json('Friend request sent');
    }

    public function cancelRequest($requestId)
    {
        $friendRequest = FriendRequest::find($requestId);

        if ($friendRequest) {
            $friendRequest->delete();
            return response()->json('Friend request canceled');
        }

        return response()->json('Friend request not found', 404);
    }

    public function delete(Request $request)
    {
        $userId = auth()->id();

        FriendRequest::where(function ($query) use ($userId) {
            $query->where('SenderUserID', $userId)
                ->orWhere('ReceiverUserID', $userId)
                ->where('Status', 'accepted');
        })->delete();

        return response()->json('Friend request deleted');
    }
}
