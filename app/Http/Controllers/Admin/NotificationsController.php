<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notification;
use phpDocumentor\Reflection\Types\Mixed_;

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
