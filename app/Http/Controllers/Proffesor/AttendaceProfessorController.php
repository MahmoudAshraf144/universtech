<?php

namespace App\Http\Controllers\Proffesor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttendaceRequest;
use App\Mail\DynamicEmail;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
//  pdf lib by barryvdh
use Illuminate\Support\Facades\Validator;


class AttendaceProfessorController extends Controller
{

    public function storeAttendace(StoreAttendaceRequest $request)
    {

        //for get lecture
        $lecture = Lecture::find($request->lecture_id);

        //for get lecture course
        $lectureCourse = $lecture->course()->first();

        // Check if the user is authenticated
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Check if the user is a professor
        if ($request->user()->type !== 1) {
            return response()->json(['error' => 'User is not a professor'], 400);
        }


        //make condition for permission
        if ($lectureCourse->professor_id != $request->user()->id) {
            return response()->json(['error' => 'not have permission to make this process'], 402);
        }

        //for check user is member in course or no
        $isMember = $lectureCourse->students()->where('student_id', $request->student_id)->exists();

        if (!$isMember) {
            return response()->json(['error' => 'student is not member in course'], 404);
        }

        //for check user already attendance or no
        $userAttendance = Attendance::where('student_id', $request->student_id)
            ->where("lec_id", $request->lecture_id)->first();

        if ($userAttendance) {
            return response()->json(['error' => 'student already have attendance'], 403);
        }

        //create attendance here
        Attendance::create(
            [
                'date' => $request->date,
                'status' => $request->status,
                'reason' => $request->reason ?: null,
                'student_id' => $request->student_id,
                'professor_id' => $request->user()->id,
                'lec_id' => $request->lecture_id,
                'course_id' => $lectureCourse->id
            ]
        );

        return response()->json(['message' => 'attendance created in successfully'], 201);
    } //end makeAttendace


}
