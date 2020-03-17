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

Broadcast::channel('new_contacts.{contact_id}', function (\App\Models\User $user, $contact_id) {
    return (int) $user->id === (int) $contact_id;
});

Broadcast::channel('new_messages.{contact_id}', function (\App\Models\User $user, $contact_id) {
    return (int) $user->id === (int) $contact_id;
});
