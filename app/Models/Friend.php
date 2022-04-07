<?php

namespace App\Models;
use App\Models\User;
use App\Models\Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'friend_id', 'type'];

    public function user(){
        return $this->belongsTo(User::class, 'friend_id');
    }
    public function profile(){
        return $this->belongsTo(Profile::class, 'friend_id', 'user_id');
    }
    
}
