<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;
    protected $primaryKey = 'FriendID';

    protected $fillable = [
        'User1',
        'User2',
    ];

    public function user1()
    {
        return $this->belongsTo(User::class, 'User1', 'id');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'User2', 'id');
    }
}
