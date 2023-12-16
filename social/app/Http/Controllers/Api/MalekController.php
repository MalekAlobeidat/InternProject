<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\FriendRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class MalekController extends Controller
{
    public function friendRequest(Request $request)
    {
        try {
            $request->validate([
                'receiver_user_id' => 'required|exists:users,id',
                'sender_user_id' => 'required|exists:users,id|different:receiver_user_id',
            ]);
            
            //make sure request exist --return true|false
            $friendRequestExists = FriendRequest::where([
                ['SenderUserID', $request->input('sender_user_id')],
                ['ReceiverUserID', $request->input('receiver_user_id')],
            ])->orWhere([
                ['SenderUserID', $request->input('receiver_user_id')],
                ['ReceiverUserID', $request->input('sender_user_id')],
            ])->exists();

            if ($friendRequestExists) {
                return response()->json(['error' => 'Friend request already exists'], 422);
            }
            $isFriends = Friend::where([
                ['User1', $request->input('sender_user_id')],
                ['User2', $request->input('receiver_user_id')],
            ])->orWhere([
                ['User1', $request->input('receiver_user_id')],
                ['User2', $request->input('sender_user_id')],
            ])->exists();

            if ($isFriends) {
                return response()->json(['error' => 'Friends Relation already exists'], 422);
            }
            
    
            $friendRequest = FriendRequest::create([
                'SenderUserID' => $request->input('sender_user_id'),
                'ReceiverUserID' => $request->input('receiver_user_id'),
                'Status' => 'pending',
            ]);
    
            return response()->json(['message' => 'Friend request sent successfully', 'data' => $friendRequest], 201);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['error' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            // Handle model not found errors (e.g., if user does not exist)
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function respondToFriendRequest(Request $request)
    {
        try {
            // Validation and authorization logic can be added here
            $request->validate([
                'sender_user_id' => 'required|exists:users,id',
                'receiver_user_id' => 'required|exists:users,id',
                'response' => 'required|in:accept,reject',
            ]);
            $resoponse = $request->response;
            // dd($request);
            $friendRequest = FriendRequest::where([
                'SenderUserID' => $request->input('sender_user_id'),
                'ReceiverUserID' => $request->input('receiver_user_id'),
                'Status' => 'pending',
            ])->orWhere([
                'SenderUserID' => $request->input('receiver_user_id'),
                'ReceiverUserID' => $request->input('sender_user_id'),
                'Status' => 'pending',
            ])->first();
            if ($friendRequest && $friendRequest->exists()) {
                if ($resoponse == "reject") {

                    $friendRequest->delete();

                    return response()->json(['message' => 'Friend request rejected successfully']);
                }else{
                    $friendRequest->delete();
                    $newFriends = Friend::create([
                        'User1' => $request->input('sender_user_id'),
                        'User2' => $request->input('receiver_user_id'),
                    ]);
                }
            }
            return response()->json(['message' => 'Friend request responded successfully', 'data' => $newFriends]);

        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['error' => $e->getMessage()], 422);
    
        } catch (ModelNotFoundException $e) {
            // Handle model not found errors
            return response()->json(['error' => 'Friend request not found or already responded'], 404);
    
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => 'An error occurred while processing the request'], 500);
        }
    }
}
