<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notifications.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('notifications.system', function ($user) {
    return true; // Cualquier usuario autenticado puede recibir notificaciones del sistema
});
