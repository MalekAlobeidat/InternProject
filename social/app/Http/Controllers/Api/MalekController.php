<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

















    // public function respond(Request $request)
    // {
    //     try {
    //         // Validation and authorization logic can be added here
    //         $request->validate([
    //             'sender_user_id' => 'required|exists:users,id',
    //             'receiver_user_id' => 'required|exists:users,id',
    //             'response' => 'required|in:accept,reject',
    //         ]);
    //         $resoponse = $request->response;
    //         // dd($request);
    //         $friendRequest = FriendRequest::where([
    //             'SenderUserID' => $request->input('sender_user_id'),
    //             'ReceiverUserID' => $request->input('receiver_user_id'),
    //             'Status' => 'pending',
    //         ])->orWhere([
    //             'SenderUserID' => $request->input('receiver_user_id'),
    //             'ReceiverUserID' => $request->input('sender_user_id'),
    //             'Status' => 'pending',
    //         ])->first();
    //         if ($friendRequest && $friendRequest->exists()) {
    //             if ($resoponse == "reject") {

    //                 $friendRequest->delete();

    //                 return response()->json(['message' => 'Friend request rejected successfully']);
    //             }else{
    //                 $friendRequest->delete();
    //                 $newFriends = Friend::create([
    //                     'User1' => $request->input('sender_user_id'),
    //                     'User2' => $request->input('receiver_user_id'),
    //                 ]);
    //             }
    //         }
    //         return response()->json(['message' => 'Friend request responded successfully', 'data' => $newFriends]);

    //     } catch (ValidationException $e) {
    //         // Handle validation errors
    //         return response()->json(['error' => $e->getMessage()], 422);
    
    //     } catch (ModelNotFoundException $e) {
    //         // Handle model not found errors
    //         return response()->json(['error' => 'Friend request not found or already responded'], 404);
    
    //     } catch (\Exception $e) {
    //         // Handle other exceptions
    //         return response()->json(['error' => 'An error occurred while processing the request'], 500);
    //     }
    // }



















    
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
        // dd($request);
        $resoponse = $request->response;

        $friend = FriendRequest::where([
            'SenderUserID' => $request->input('sender_user_id'),
            'ReceiverUserID' => $request->input('receiver_user_id'),
            'Status' => 'accepted',
        ])->first();
        if ($friend !== null) {
            return response()->json(['message' => 'sender_user_id and receiver_user_id is already friends if you want to delete it try to use FriendCancle APi']);
        }

        $friend = FriendRequest::where([
            'SenderUserID' => $request->input('receiver_user_id'),
            'ReceiverUserID' => $request->input('sender_user_id'),
            'Status' => 'accepted',
        ])->first();
        if ($friend !== null) {
            return response()->json(['message' => 'sender_user_id and receiver_user_id is already friends if you want to delete it try to use FriendCancle APi']);
        }




        $friendRequest = FriendRequest::where([
            'SenderUserID' => $request->input('sender_user_id'),
            'ReceiverUserID' => $request->input('receiver_user_id'),
            'Status' => 'pending',
        ])->first();


        if ($friendRequest->exists()) {
            if ($resoponse == "reject") {
                $friendRequest->delete();

                return response()->json(['message' => 'Friend request rejected successfully']);
            }else{
                $friendRequest->update([
                    'Status' => 'accepted',
                ]);
                $friendRequest->save();
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
public function friendsPosts($yourUserID){

    // $posts = DB::table('posts')
    // ->join('friend_requests', function ($join) use ($yourUserID) {
    //     $join->on('posts.UserID', '=', 'friend_requests.SenderUserID')
    //         ->orOn('posts.UserID', '=', 'friend_requests.ReceiverUserID');
    // })
    // ->join('users', function ($join) {
    //     $join->on('users.id', '=', 'posts.UserID');
    // })
    // ->where(function ($query) use ($yourUserID) {
    //     $query->where('friend_requests.SenderUserID', $yourUserID)
    //         ->orWhere('friend_requests.ReceiverUserID', $yourUserID);
    // })
    // ->where('friend_requests.Status', 'accepted')
    // ->select('users.name as userName', 'users.ProfilePicture', 'posts.*')
    // ->distinct()
    // ->orderBy('posts.created_at', 'desc')
    // ->get();





    $data = Post::join('friend_requests', function ($join) use ($yourUserID) {
        $join->on('posts.UserID', '=', 'friend_requests.SenderUserID')
            ->orOn('posts.UserID', '=', 'friend_requests.ReceiverUserID');
    })
    ->join('users', function ($join) {
        $join->on('users.id', '=', 'posts.UserID');
    })
    ->where(function ($query) use ($yourUserID) {
        $query->where('friend_requests.SenderUserID', $yourUserID)
            ->orWhere('friend_requests.ReceiverUserID', $yourUserID);
    })
    ->where('friend_requests.Status', 'accepted')
    ->select('users.name as userName', 'users.ProfilePicture', 'posts.*')
    ->distinct()
    ->orderBy('posts.created_at', 'desc')
    ->get();

    if ($data->isEmpty()) {
        return $this->getUserPosts($yourUserID);
    }



    

    return response()->json(['posts'=>$data]);
}




public function getUserPosts($userId)
{
    $user = User::find($userId);

    // Check if the user exists
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }
    $posts = Post::join('users', function ($join) {
        $join->on('users.id', '=', 'posts.UserID');
    })->where('posts.UserID', $userId)
    ->select('users.name as userName', 'users.ProfilePicture', 'posts.*')
    ->distinct()
    ->orderBy('posts.created_at', 'desc')
    ->get();


    return response()->json($posts);
}

public function getUserPostsAndInteractions($userId)
{
    $posts = Post::where('UserID', $userId)
        ->withCount('likes')
        ->with(['comments' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }])
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json($posts);
    }




public function getUserAndFriendsPosts($userId)
{
    $userAndFriendsPosts = Post::with(['user', 'likes' => function ($query) {
        $query->select('PostID', DB::raw('COUNT(*) as TotalLikes'))
            ->groupBy('PostID');
    }])
    ->with(['comments'])
    ->where(function ($query) use ($userId) {
        $query->where('UserID', $userId)
            ->orWhereIn('UserID', function ($query) use ($userId) {
                $query->select('SenderUserID')
                    ->from('friend_requests')
                    ->where('Status', 'accepted')
                    ->where('ReceiverUserID', $userId);
            })
            ->orWhereIn('UserID', function ($query) use ($userId) {
                $query->select('ReceiverUserID')
                    ->from('friend_requests')
                    ->where('Status', 'accepted')
                    ->where('SenderUserID', $userId);
            });
    })
    ->orderBy('created_at', 'desc')
    ->get();

// Rename the likes_count property to TotalLikes for consistency
$userAndFriendsPosts->transform(function ($post) {
    $post->TotalLikes = $post->likes->first()->TotalLikes ?? 0;
    unset($post->likes);

    // Include user name and profile picture in the post
    $post->UserName = $post->user->name ?? null;
    $post->UserProfilePicture = $post->user->ProfilePicture ?? null;

    unset($post->user);

    return $post;
});
    return response()->json($userAndFriendsPosts);
}


function getFriendsCount($userId) {
    $friendsCount = FriendRequest::where(function ($query) use ($userId) {
            $query->where('SenderUserID', $userId)
                ->orWhere('ReceiverUserID', $userId);
        })
        ->where('Status', 'accepted')
        ->count();
        return response()->json(['Friends' =>$friendsCount]);

}


function getUserFriends($userId) {
    $userFriends = User::join('friend_requests', function ($join) use ($userId) {
            $join->on('users.id', '=', 'friend_requests.SenderUserID')
                ->where('friend_requests.ReceiverUserID', $userId)
                ->where('friend_requests.Status', 'accepted')
                ->orWhere(function ($query) use ($userId) {
                    $query->on('users.id', '=', 'friend_requests.ReceiverUserID')
                        ->where('friend_requests.SenderUserID', $userId)
                        ->where('friend_requests.Status', 'accepted');
                });
        })
        ->select('users.id as FriendID', 'users.name as FriendName', 'users.ProfilePicture as FriendProfilePicture')
        ->get();

        return response()->json(['userFriends' =>$userFriends]);


}

}
