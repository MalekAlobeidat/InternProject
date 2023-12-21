<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'RoleID',
        'ProfilePicture',
        'OtherProfileInfo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    public function role()
    {
        return $this->belongsTo(UserRole::class, 'RoleID');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'UserID');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'UserID');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'UserID');
    }

    public function sentFriendRequests()
    {
        return $this->hasMany(FriendRequest::class, 'SenderUserID');
    }

    public function receivedFriendRequests()
    {
        return $this->hasMany(FriendRequest::class, 'ReceiverUserID');
    }
    public function User1()
    {
        return $this->hasMany(Friend::class, 'User1');
    }
    public function User2()
    {
        return $this->hasMany(Friend::class, 'User2');
    }
    public function reports()
    {
        return $this->hasMany(Report::class, 'UserID');
    }
    public function publicPosts()
    {
        return $this->posts()->where('privacy_id', 2); // Assuming 2 represents 'Everyone' privacy setting
    }
}
