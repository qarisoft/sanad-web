<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('company.{id}', function ($user, $id) {
    return $user;
});
Broadcast::channel('company', function ($user) {
    return $user;
});
Broadcast::channel('tasks', function ($user) {
    return $user;
});
