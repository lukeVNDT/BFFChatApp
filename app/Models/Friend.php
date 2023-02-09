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
    public function subuser(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function profileuser(){
        return $this->belongsTo(Profile::class, 'friend_id');
    }
    public function profilesubuser(){
        return $this->belongsTo(Profile::class, 'user_id');
    }
    public function unionprofileuser(){
        return $this->user()->union($this->profileuser()->toBase());
    }
    public function unionprofilesubuser(){
        return $this->subuser()->union($this->profilesubuser()->toBase());
    }
    public function profile(){
        return $this->belongsTo(Profile::class, 'friend_id', 'user_id');
    }
    
}
