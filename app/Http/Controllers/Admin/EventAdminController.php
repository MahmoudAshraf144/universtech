<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAddEvent;
use App\Http\Requests\Admin\AdminUpdateEventRequest;
use App\Models\Event;
use App\Traits\File\DeleteFile;
use App\Traits\File\UpdateFile;
use App\Traits\File\UploadFile;
use Illuminate\Http\Request;

class EventAdminController extends Controller
{
    use UploadFile, DeleteFile, UpdateFile;

    //function for show all events
    function index(Request $request)
    {

        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        return response()->json(
            Event::orderByDesc("created_at")->with('admin')->get()
                ->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->title,
                        'content' => $event->content,
                        'image' => $event->image,
                        'created_at' => $event->created_at,
                        'updated_at' => $event->updated_at,
                        'admin_name' => $event->admin ? $event->admin->name : null,
                    ];
                })
        );
    } //end index


    function getEventById(Request $request, $id)
    {
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $event = Event::where('id', $id)->first();

        if (!$event) {
            return response()->json(['error' => 'not event exist have this id'], 404);
        } //end if

        return response()->json($event);
    } //end getEventById

    //function for make store for event
    function store(AdminAddEvent $request)
    {

        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $adminId = $admin->id;

        $path = $this->uploadFile(
            request: $request,
            key: 'image',
            folder: 'events'
        );

        Event::create(
            [
                'title' => $request->title,
                'content' => $request->content,
                'admin_id' => $adminId,
                'image' => $path
            ]
        );

        return response()->json(['message' => 'event created in successfully'], 201);
    } //end store


    //function for delete event by id
    function delete(Request $request, $id)
    {

        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $event = Event::where('id', $id)->first();

        if (!$event) {
            return response()->json(['error' => 'not exist event have this id'], 404);
        }

        Event::where('id', $id)->delete();

        $this->deleteFile(
            path: $event->image
        );

        return response()->json(['message' => 'event deleted in successfully'], 200);
    } //end delete


    //function for update event
    function update(AdminUpdateEventRequest $request)
    {

        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $event = Event::where('id', $request->event_id)->first();
        if (!$event) {
            return response()->json(['error' => 'not exist event have this id'], 404);
        } //end if

        $path = $event->image;
        if ($request->hasFile('image')) {

            $path = $this->updateFile(
                oldPath: $path,
                request: $request,
                key: 'image',
                folder: 'events'
            );
        } //end if

        Event::where('id', $request->event_id)->update(
            [
                "title" => $request->title ?: $event->title,
                "content" => $request->content ?: $event->content,
                'image' => $path
            ]
        );

        return response()->json(['message' => 'event updated in successfully'], 201);
    } //end update

}
