<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAddScheduleRequest;
use App\Models\Schedule;
use App\Traits\File\UpdateFile;
use App\Traits\File\UploadFile;
use Illuminate\Http\Request;

class ScheduleAdminController extends Controller
{
    use UpdateFile, UploadFile;

    function store(AdminAddScheduleRequest $request)
    {
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $schedule = Schedule::where('level_id', $request->level_id)->first();

        if ($schedule) {

            $path = $this->updateFile(
                oldPath: $schedule->path,
                request: $request,
                key: 'image',
                folder: 'schedules'
            );

            Schedule::where('level_id', $request->level_id)->update(
                [
                    'path' => $path
                ]
            );
        } //end if

        else {

            $path = $this->uploadFile(
                request: $request,
                key: 'image',
                folder: 'schedules'
            );

            Schedule::insert(
                [
                    'path' => $path,
                    'level_id' => $request->level_id,
                    'admin_id' => $admin->id
                ]
            );
        } //end else

        return response()->json(['message' => 'schedule store in successfully'], 201);

    } //end store

}//end ScheduleAdminController
