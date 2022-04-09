<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Notify;
use App\Models\Friend;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function message(){
        return $this->hasMany(Message::class, 'user_id');
    }

    public function notify(){
        return $this->hasMany(Notify::class, 'user_id');
    }

    public function profile(){
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function friend(){
        return $this->hasMany(Friend::class, 'friend_id');
    }

    public function search($keyword){
        return Profile::where('displayName','LIKE','%'.$keyword.'%' );
    }
    
   
}
