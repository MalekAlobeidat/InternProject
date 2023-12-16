<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $primaryKey = 'CommentID';

    protected $fillable = [
        'UserID',
        'PostID',
        'CommentText',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'PostID');
    }
}
