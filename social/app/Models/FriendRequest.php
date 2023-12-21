<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    use HasFactory;

    protected $primaryKey = 'RequestID';

    protected $fillable = [
        'SenderUserID',
        'ReceiverUserID',
        'Status',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'SenderUserID');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'ReceiverUserID');
    }
    public static function areFriends($userId1, $userId2)
    {
        return self::where(function ($query) use ($userId1, $userId2) {
            $query->where('SenderUserID', $userId1)
                ->where('ReceiverUserID', $userId2)
                ->where('Status', 'accepted');
        })->orWhere(function ($query) use ($userId1, $userId2) {
            $query->where('SenderUserID', $userId2)
                ->where('ReceiverUserID', $userId1)
                ->where('Status', 'accepted');
        })->exists();
    } 
}
