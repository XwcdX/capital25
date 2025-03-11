<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('rally.{rally_id}.phase.{phase_id}', function ($user, $rally_id, $phase_id) {
    return true;
});