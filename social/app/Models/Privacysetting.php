<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privacysetting extends Model
{
    use HasFactory;
    protected $primaryKey = 'PrivacyID';

    protected $fillable = [
        'PrivacyName',
    ];


    public function posts()
    {
        return $this->hasMany(Post::class, 'PrivacyID');
    }
}
