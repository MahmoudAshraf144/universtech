<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminStoreAccountRequest;
use App\Http\Requests\Admin\AdminUpdateUserRequest;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountAdminController extends Controller
{

    //function for return all doctors
    function getDoctors(Request $request)
    {
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if


        return response()->json(
            User::where("type",1)->orderByDesc("created_at")->with('admin')->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'gender' => $user->gender,
                        'nationalid' => $user->nationalid,
                        'phone' => $user->phone,
                        'credit_points' => $user->credit_points,
                        'type' => $user->type,
                        'job_title' => $user->job_title,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                        'admin_name' => $user->admin ? $user->admin->name : null,
                    ];
                })
        );
    } //end index


    //function for return all students
    function getStudents(Request $request)
    {
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if


        return response()->json(
            User::where("type",0)->orderByDesc("created_at")->with('admin', 'department', 'level')->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'gender' => $user->gender,
                        'nationalid' => $user->nationalid,
                        'phone' => $user->phone,
                        'credit_points' => $user->credit_points,
                        'semester' => $user->semester,
                        'type' => $user->type,
                        'department' => $user->department ? $user->department->name : null,
                        'level' => $user->level ? $user->level->name : null,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                        'admin_name' => $user->admin ? $user->admin->name : null,
                    ];
                })
        );
    } //end index

    //function for store account as professor or student
    function store(AdminStoreAccountRequest $request)
    {

        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $adminId = $admin->id;
        User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'nationalid' => $request->nationalid ?: null,
                'phone' => $request->phone ?: null,
                'credit_points' => $request->credit_points ?: null,
                'semester' => $request->semester ?: null,
                'type' => $request->type,
                'department_id' => $request->department_id ?: null,
                'level_id' => $request->level_id ?: null,
                'admin_id' => $adminId,
                'job_title' => $request->job_title ?: null
            ]
        );

        return response()->json(['message' => 'account created in successfully'], 201);
    } //end store


    function getUserById(Request $request, $id)
    {
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $user = User::where('id', $id)->first();

        if (!$user) {
            return response()->json(['error' => 'not user exist have this id'], 404);
        } //end if

        return response()->json($user);
    } //end getEventById


    function delete(Request $request, $id)
    {
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $user = User::where('id', $id)->first();

        if (!$user) {
            return response()->json(['error' => 'not exist user have this id'], 404);
        }

        User::where('id', $id)->delete();

        return response()->json(['message' => 'user deleted in successfully'], 200);
    } //end delete


    //function for update department
    function update(AdminUpdateUserRequest $request)
    {
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $user = User::where('id', $request->account_id)->first();
        if (!$user) {
            return response()->json(['error' => 'not exist user have this id'], 404);
        } //end if

        User::where('id', $request->account_id)->update(
            [
                'name' => $request->name ?: $user->name,
                'email' => $request->email ?: $user->email,
                'password' => Hash::make($request->password) ?: $user->password,
                'gender' => $request->gender ?: $user->gender,
                'nationalid' => $request->nationalid ?: $user->nationalid,
                'phone' => $request->phone ?: $user->phone,
                'credit_points' => $request->credit_points ?: $user->credit_points,
                'semester' => $request->semester ?: $user->semester,
                'type' => $request->type ?: $user->type,
                'department_id' => $request->department_id ?: $user->department_id,
                'level_id' => $request->level_id ?: $user->level_id,
                'job_title' => $request->job_title ?: $user->job_title
            ]
        );

        return response()->json(['message' => 'user updated in successfully'], 201);
    } //end update


}
