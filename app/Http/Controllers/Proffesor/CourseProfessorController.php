<?php

namespace App\Http\Controllers\Proffesor;

use App\Http\Controllers\Controller;
use App\Http\Resources\Professor\StudentCourseResource;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CourseProfessorController extends Controller
{

    public function getProfessorCourses(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            // Add validation rules here if necessary
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Check if the user is authenticated
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Check if the user is a professor
        if ($request->user()->type !== 1) {
            return response()->json(['error' => 'User is not a professor'], 400);
        }

        // Load courses and students
        $courses = Course::where('professor_id',$request->user()->id)->orderByDesc('created_at')->get();

        return response()->json($courses);
    }//end getProfessorCourses


    public function getCoursesStudent(Request $request)
    {
        //Validate the request data
        $validator = Validator::make($request->all(), [
            // Add validation rules here if necessary
            'course_id' => 'required|exists:courses,id'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $course = Course::find($request->course_id);

        // Check if the user is authenticated
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Check if the user is a professor
        if ($request->user()->type !== 1) {
            return response()->json(['error' => 'User is not a professor'], 400);
        }

        // Check if the user is a professor
        if ($request->user()->id !== $course->professor_id) {
            return response()->json(['error' => 'not have permission for this process'], 403);
        }

        return response()->json(StudentCourseResource::collection($course->students()->get()));
    }

}//end CourseProfessorController
