<?php
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('login-user.{userId}', function ($user, $id) {
    return $user->roles('customer')->first()->id === (int) $id;
});
Broadcast::channel('order-update.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
Broadcast::channel('admin.orders', function ($user) {
    return $user && $user->hasRole('admin'); // Only allow admins
});