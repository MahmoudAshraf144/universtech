<?php

namespace App\Http\Controllers\Proffesor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Professor\ProfessorAddLectureRequest;
use App\Models\Course;
use App\Models\Lecture;
use App\Traits\File\UploadFile;
use Illuminate\Http\Request;

class LectureProfessorController extends Controller
{

    use UploadFile;

    //function for return lectures course
    function getLecturesCourse(Request $request, $id)
    {
        $professor = $request->user();
        if (!$professor) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $course = Course::where('id', $id)->first();

        if ($course->professor_id != $professor->id) {
            return response()->json(['error' => 'professor not have permission for add lecture to this course'], 403);
        } //end if

        return response()->json(
            Lecture::where("course_id", $id)->orderByDesc("created_at")->get()
                ->map(function ($lecture) {
                    return [
                        'id' => $lecture->id,
                        'name' => $lecture->name,
                        'path' => $lecture->content,
                        'created_at' => $lecture->created_at,
                        'updated_at' => $lecture->updated_at,
                    ];
                })
        );
    } //end getLecturesCourse

    function store(ProfessorAddLectureRequest $request)
    {
        $professor = $request->user();
        if (!$professor) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $course = Course::where('id', $request->course_id)->first();

        if ($course->professor_id != $professor->id) {
            return response()->json(['error' => 'professor not have permission for add lecture to this course'], 403);
        } //end if

        $path = $this->uploadFile(
            request: $request,
            key: 'pdf',
            folder: 'lectures',
        );

        Lecture::create(
            [
                'name' => $request->name,
                'content' => $path,
                'course_id' => $request->course_id
            ]
        );

        return response()->json(['message' => 'lecture store in successfully'], 201);
    } //end store

}//end LectureProfessorController
