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
}
