<?php

use App\Http\Controllers\API\FactsController;
use App\Http\Controllers\API\User\LogoutController;
use App\Http\Controllers\API\User\NotificationsController;
use App\Http\Controllers\API\User\UserController;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CoursesResource;
use App\Http\Resources\LecturesResource;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\StudentCourse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('logout',LogoutController::class);
Route::get('',UserController::class);
Route::get('facts',FactsController::class);
Route::get('');

//Start Notifications
Route::get('notifications',[NotificationsController::class , 'notifications'])->name('notifications');
Route::get('events',[NotificationsController::class, 'events'])->name('events');
Route::get('announcments',[NotificationsController::class , 'announcments'])->name('announcments');
//End Notifications

Route::get('courses',function(){
    $courses = auth()->user()->courses;

    return SendResponse(200,"User's Courses fetched successfully",
        CoursesResource::collection(auth()->user()->courses)
    );
});

Route::get('course/{id}',function($id){
    $course = StudentCourse::find($id)->with('course.lectures')->get();
    return SendResponse(200,"Lectures fetched successfully",
    CourseResource::collection($course)
    );
});

Route::get('lecture/{lecture_id}',function($lecture_id){
    $lecture = Lecture::find($lecture_id);
    return SendResponse(200,"Lecture fetched successfully",
    new LecturesResource($lecture)
    );
});

Route::post('update_progress',function(){
    $data = request()->validate([
        'course_id' => 'required|exists:courses,id',
    ]);

    $student_course = StudentCourse::where('student_id',auth()->id())->where('course_id',$data['course_id'])->first();
    $progress = $student_course->progress;
    $student_course->update(['progress'=>$progress+1]);
    return SendResponse(200,"Progress updated successfully");

});
