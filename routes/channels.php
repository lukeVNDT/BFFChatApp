<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('bffchatnotify.{receiver_id}', function ($user, $receiverid) {
    return auth()->check();
});

Broadcast::channel('bffchatacceptuser.{receiver_id}', function ($user, $receiverid) {
    return auth()->check();
});

Broadcast::channel('bffchatacceptsubuser.{receiver_id}', function ($user, $receiverid) {
    return auth()->check();
});

Broadcast::channel('privatebffchat.{receiverid}', function ($user, $receiverid) {
    return auth()->check();
});
Broadcast::channel('bffchat', function ($user) {
    if(auth()->check()){
        return $user;
    }
});

