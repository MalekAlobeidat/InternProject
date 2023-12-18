<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

















    public function respond(Request $request)
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


















    public function updateUser(Request $request, $userId)
{
    try {
        $user = User::findOrFail($userId);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'RoleID' => 'required|exists:user_roles,RoleID',
            'ProfilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'OtherProfileInfo' => 'nullable',
        ]);
        // Update only if the input exists in the request, otherwise use original values
        $user->name = $request->filled('name') ? $request->input('name') : $user->name;
        $user->email = $request->filled('email') ? $request->input('email') : $user->email;
        $user->RoleID = $request->filled('RoleID') ? $request->input('RoleID') : $user->RoleID;
        $user->OtherProfileInfo = $request->filled('OtherProfileInfo') ? $request->input('OtherProfileInfo') : $user->OtherProfileInfo;

        // Update profile picture only if the input exists and is a valid file
        // if ($request->hasFile('ProfilePicture') && $request->file('ProfilePicture')->isValid()) {
        //     // Delete the old profile picture
        //     Storage::disk('public')->delete($user->ProfilePicture);

        //     // Upload the new profile picture
        //     $imagePath = $request->file('ProfilePicture')->store('profile_pictures', 'public');
        //     $user->ProfilePicture = $imagePath;
        // }
        if ($request->hasFile('ProfilePicture') && $request->file('ProfilePicture')->isValid()) {
            // Delete the old profile picture
            if ($user->ProfilePicture) {
                Storage::disk('public')->delete($user->ProfilePicture);
            }

            // Upload the new profile picture
            $imagePath = $request->file('ProfilePicture')->store('profile_pictures', 'public');
            $user->ProfilePicture = 'http://127.0.0.1:8001/storage' . '/' .$imagePath;
        }
        $user->save();

        return response()->json(['message' => 'User updated successfully', 'data' => $user]);

    } catch (ValidationException $exception) {
        return response()->json(['error' => $exception->errors()], 422);
    } catch (\Exception $exception) {
        return response()->json(['error' => $exception->getMessage()], 500);
    }
}




















public function test(Request $request)
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
                $friendRequest->update([
                    'Status' => 'accepted',
                ]);=======
                $friendRequest->save();
                dd($friendRequest);

            }
        }
        return response()->json(['message' => 'Friend request responded successfully', 'data' => $friendRequest]);

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
