<?php

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

Broadcast::channel('App.User.{id}', static function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('idea', static function ($user) {
    return [
        'id' => $user->id,
        'uuid' => $user->uuid,
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
    ];
});
