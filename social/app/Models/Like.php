<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $primaryKey = 'LikeID';

    
    protected $fillable = [
        'UserID',
        'PostID',
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
