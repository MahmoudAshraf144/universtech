<?php

use App\Http\Controllers\Admin\AccountAdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CourseAdminController;
use App\Http\Controllers\Admin\DepartmentAdminController;
use App\Http\Controllers\Admin\EventAdminController;
use App\Http\Controllers\Admin\ScheduleAdminController;
use App\Http\Controllers\Proffesor\AuthController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\Proffesor\CourseProfessorController;
use App\Http\Controllers\Proffesor\AttendaceProfessorController;
use App\Http\Controllers\proffesor\EventProfessorController;
use App\Http\Controllers\Proffesor\LectureProfessorController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get("hello", function () {
    return 11;
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::group(['prefix' => 'prof/auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::group(['prefix' => 'admin/auth'], function () {
    Route::post('login', [AdminAuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->post("admin/auth/logout", [AdminAuthController::class, "logout"]);

Route::middleware('auth:sanctum')->get("admin/profile", [AdminAuthController::class, "me"]);

Route::middleware('auth:sanctum')->post("event/store", [EventAdminController::class, "store"]);

Route::middleware('auth:sanctum')->get("event/get/all", [EventAdminController::class, "index"]);

Route::middleware('auth:sanctum')->delete("event/delete/{id}", [EventAdminController::class, "delete"]);

Route::middleware('auth:sanctum')->get("event/single/{id}", [EventAdminController::class, "getEventById"]);

Route::middleware('auth:sanctum')->post("event/update", [EventAdminController::class, "update"]);

Route::middleware('auth:sanctum')->post("user/store", [AccountAdminController::class, "store"]);

Route::middleware('auth:sanctum')->get("doctor/get/all", [AccountAdminController::class, "getDoctors"]);

Route::middleware('auth:sanctum')->get("student/get/all", [AccountAdminController::class, "getStudents"]);

Route::middleware('auth:sanctum')->get("user/single/{id}", [AccountAdminController::class, "getUserById"]);

Route::middleware('auth:sanctum')->put("user/update", [AccountAdminController::class, "update"]);

Route::middleware('auth:sanctum')->delete("user/delete/{id}", [AccountAdminController::class, "delete"]);

Route::middleware('auth:sanctum')->get("department/get/all", [DepartmentAdminController::class, "index"]);

Route::middleware('auth:sanctum')->get("department/single/{id}", [DepartmentAdminController::class, "getDepartmentById"]);

Route::middleware('auth:sanctum')->post("department/store", [DepartmentAdminController::class, "store"]);

Route::middleware('auth:sanctum')->delete("department/delete/{id}", [DepartmentAdminController::class, "delete"]);

Route::middleware('auth:sanctum')->put("department/update", [DepartmentAdminController::class, "update"]);

//course
Route::middleware('auth:sanctum')->post("course/store", [CourseAdminController::class, "store"]);

Route::middleware('auth:sanctum')->get("course/get/all", [CourseAdminController::class, "index"]);

Route::middleware('auth:sanctum')->delete("course/delete/{id}", [CourseAdminController::class, "delete"]);

Route::middleware('auth:sanctum')->get("course/single/{id}", [CourseAdminController::class, "getCourseById"]);

Route::middleware('auth:sanctum')->post("course/update", [CourseAdminController::class, "update"]);

Route::middleware('auth:sanctum')->post("schedule/store", [ScheduleAdminController::class, "store"]);

Route::middleware('auth:sanctum')->get('professors/courses', [CourseProfessorController::class, 'getProfessorCourses']);

Route::middleware('auth:sanctum')->get('professors/course/student', [CourseProfessorController::class, 'getCoursesStudent']);

Route::middleware('auth:sanctum')->post('professors/make/attendance', [AttendaceProfessorController::class, 'storeAttendace']);

Route::middleware('auth:sanctum')->post('lecture/store', [LectureProfessorController::class, 'store']);

Route::middleware('auth:sanctum')->get('lecture/get/all/{id}', [LectureProfessorController::class, 'getLecturesCourse']);

Route::middleware('auth:sanctum')->post("professor/auth/logout", [AuthController::class, "logout"]);

Route::middleware('auth:sanctum')->get("professor/profile", [AuthController::class, "me"]);

Route::middleware('auth:sanctum')->get("professor/event/get/new", [EventProfessorController::class, "latestEvents"]);
