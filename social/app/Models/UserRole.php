<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    
    protected $primaryKey = 'RoleID';

    protected $fillable = [
        'RoleName',
    ];
    use HasFactory;
    public function users()
    {
        return $this->hasMany(User::class, 'RoleID');
    }
}
