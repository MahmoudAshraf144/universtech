<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationsResource;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function events()
    {
        $events = Notification::where('student_id', null)
            ->latest()
            ->get();
        return SendResponse(200, 'Events fetched successfully', NotificationsResource::collection($events));
    }

    public function announcments()
    {
        $announcments = Notification::where('student_id', auth()->id())
            ->orWhere('student_id', null) //Events
            ->latest()
            ->get();
        return SendResponse(200, 'Announcments fetched successfully', NotificationsResource::collection($announcments));
    }

    public function notifications()
    {
        $notifications = Notification::where('student_id', auth()->id())
            ->latest()
            ->get();
    return SendResponse(200, 'Notifications fetched successfully', NotificationsResource::collection($notifications));
    }
}
