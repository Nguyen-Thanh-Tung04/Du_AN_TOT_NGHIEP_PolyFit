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

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('orders-channel', function () {
    return true; // Cho phép tất cả người dùng lắng nghe
});

Broadcast::channel('chat', function ($user) {
    if($user != null) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    return false;
});
Broadcast::channel('chat.private.{idUserSend}.{idUserReciever}',function($user,$idUserSend,$idUserReciever){
    if($user != null){
        if($user->id == $idUserSend || $user->id == $idUserReciever){
            return true;
        }
    }
    return false;
});