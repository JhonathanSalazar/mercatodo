<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{


    /**
     * Return the unread notifications.
     *
     * @return mixed
     */
    public function index()
    {
        return auth()->user()->unreadNotifications;
    }

    /**
     * Mark as read the notification selected
     *
     * @param string $notification
     */
    public function read(string $notification): void
    {
        DatabaseNotification::find($notification)->markAsRead();
    }

}
