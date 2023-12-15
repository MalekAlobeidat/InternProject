<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;


    protected $fillable = [
        'UserID',
        'Content',
        'Media',
        'PrivacyID',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function privacySetting()
    {
        return $this->belongsTo(PrivacySetting::class, 'PrivacyID');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'PostID');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'PostID');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'PostID');
    }
}
