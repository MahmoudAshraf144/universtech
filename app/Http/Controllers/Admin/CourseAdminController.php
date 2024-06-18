<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAddCourseRequest;
use App\Http\Requests\Admin\AdminUpdateCourseRequest;
use App\Models\Course;
use App\Models\User;
use App\Traits\File\DeleteFile;
use App\Traits\File\UpdateFile;
use App\Traits\File\UploadFile;
use Illuminate\Http\Request;

class CourseAdminController extends Controller
{
    use UploadFile, DeleteFile, UpdateFile;

    function index(Request $request)
    {

        //
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        return response()->json(
            Course::orderByDesc("created_at")->with('admin', 'department', 'user')->get()
                ->map(function ($course) {
                    return [
                        'id' => $course->id,
                        'course_name' => $course->course_name,
                        'no_of_hours' => $course->no_of_hours,
                        'course_code' => $course->course_code,
                        'cover_image' => $course->cover_image,
                        'department' => $course->department ? $course->department->name : null,
                        'professor' => $course->department ? $course->professor->name : null,
                        'lecture_count' => count($course->lectures),
                        'admin_name' => $course->admin ? $course->admin->name : null,
                        'updated_at' => $course->updated_at,
                        'created_at' => $course->created_at,
                    ];
                })
        );
    } //end index


    //function for store new course in global database
    function store(AdminAddCourseRequest $request)
    {
        //
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if


        if (User::where('id', $request->professor_id)->first()->type != 1) {
            return response()->json(['error' => 'user is student not professor'], 402);
        } //end if

        $path = null;
        //
        if ($request->hasFile('cover_image')) {

            $path = $this->uploadFile(
                request: $request,
                key: 'cover_image',
                folder: 'courses'
            );
        } //end if

        //
        Course::create(
            [
                'course_name' => $request->course_name,
                'no_of_hours' => $request->no_of_hours,
                'course_code' => $request->course_code,
                'cover_image' => $path ?: 'default.jpg',
                'department_id' => $request->department_id,
                'professor_id' => $request->professor_id,
                'admin_id' => $admin->id,
            ]
        );

        return response()->json(['message' => 'course created in successfully'], 201);
    } //end store


    function delete(Request $request, $courseId)
    {
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $course = Course::where('id', $courseId)->first();

        if (!$course) {
            return response()->json(['error' => 'not exist course have this id'], 404);
        } //end if

        //
        Course::where('id', $courseId)->delete();

        if ($course->cover_image != 'default.jpg') {
            $this->deleteFile(
                path: $course->cover_image
            );
        } //end if

        return response()->json(['message' => 'course deleted in successfully'], 201);
    } //end delete


    function getCourseById(Request $request, $id)
    {
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $course = Course::where('id', $id)->first();

        if (!$course) {
            return response()->json(['error' => 'not course exist have this id'], 404);
        } //end if

        return response()->json($course);
    } //end getEventById


    function update(AdminUpdateCourseRequest $request)
    {
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $course = Course::where('id', $request->course_id)->first();

        if (!$course) {
            return response()->json(['error' => 'not course exist have this id'], 404);
        } //end if


        if ($request->professor_id) {

            if (User::where('id', $request->professor_id)->first()->type != 1) {
                return response()->json(['error' => 'user is student not professor'], 402);
            } //end if

        }//end if

        $path = $course->cover_image;
        if ($request->hasFile('cover_image')) {

            if ($course->cover_image != 'default.jpg') {

                $path = $this->updateFile(
                    oldPath: $path,
                    request: $request,
                    key: 'cover_image',
                    folder: 'courses'
                );
            } //end if
            else {

                $path = $this->uploadFile(
                    request: $request,
                    key: 'cover_image',
                    folder: 'courses'
                );
            } //end else
        } //end if

        Course::where('id', $request->course_id)->update(
            [
                "course_name" => $request->course_name ?: $course->course_name,
                "no_of_hours" => $request->no_of_hours ?: $course->no_of_hours,
                'course_code' => $request->course_code ?: $course->course_code,
                'department_id' => $request->department_id ?: $course->department_id,
                'professor_id' => $request->professor_id ?: $course->professor_id,
                'cover_image' => $path
            ]
        );

        return response()->json(['message' => 'course updated in successfully'], 201);
    } //end update


}//end CourseAdminController
