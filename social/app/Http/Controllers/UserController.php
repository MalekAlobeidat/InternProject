<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\FriendRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class UserController extends Controller
{
    public function createUser(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'password' => 'required',
            'ProfilePicture' => 'nullable|url',
            'RoleID' => 'required|integer'
        ]);

        if (empty($validatedData)) {
            return response()->json(['message' => 'Please enter data.']);
        }

        $user = new User();
        $user->email = $validatedData['email'];
        $user->name = $validatedData['name'];
        $user->password = bcrypt($validatedData['password']);
        $user->RoleID = $validatedData['RoleID'] ?? 1;

        if ($request->hasFile('ProfilePicture')) {
            $file = $request->file('ProfilePicture');
            $path = $file->store('public/profilePictures');
            $user->profilePicture = Storage::url($path);
        }

        $user->save();

        return response()->json(['message' => 'User created successfully']);
    }
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'email' => 'email|unique:users,email,' . $user->id,
            'name' => 'string',
            'password' => 'string',
            'ProfilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'RoleID' => 'integer'
        ]);

        $user->email = $validatedData['email'] ?? $user->email;
        $user->name = $validatedData['name'] ?? $user->name;

        if (isset($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }

        if ($request->hasFile('ProfilePicture')) {
            $file = $request->file('ProfilePicture');
            $path = $file->store('public/profilePictures');
            $user->profilePicture = Storage::url($path);
        }

        $user->RoleID = $validatedData['RoleID'] ?? $user->RoleID;
        $user->save();

        return response()->json(['message' => 'User updated successfully']);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
    public function showProfile(Request $request, $userId)
{
    $authUser = $request->user();

    // Check if the user is authenticated
    if (!$authUser) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    try {
        // Rest of your code to show the user's profile...
    } catch (ModelNotFoundException $e) {
        return response()->json([
            'message' => 'User not found.',
            'exception_message' => $e->getMessage(),
        ], 404);
    }}

}
