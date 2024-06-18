<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAddDepartmentRequest;
use App\Http\Requests\Admin\AdminUpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentAdminController extends Controller
{

    //function for show all departments
    function index(Request $request)
    {
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        return response()->json(
            Department::orderByDesc("created_at")->with('admin')->get()
                ->map(function ($department) {
                    return [
                        'id' => $department->id,
                        'name' => $department->name,
                        'created_at' => $department->created_at,
                        'updated_at' => $department->updated_at,
                        'abbrevation' => $department->abbrevation,
                        'admin_name' => $department->admin ? $department->admin->name : null, // الحصول على اسم المدير فقط
                    ];
                })
        );
    } //end index


    //function for store department
    function store(AdminAddDepartmentRequest $request)
    {
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $adminId = $admin->id;
        Department::create(
            [
                'name' => $request->name,
                'admin_id' => $adminId,
                'abbrevation' => $request->abbrevation
            ]
        );

        return response()->json(['message' => 'account created in successfully'], 201);
    } //end store


    //function for get department by id
    function getDepartmentById(Request $request, $id)
    {
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $department = Department::where('id', $id)->first();

        if (!$department) {
            return response()->json(['error' => 'not found department'], 404);
        } //end if

        return response()->json($department);
    } //ent getDepartmentById


    //function for delete department
    function delete(Request $request, $id)
    {
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $event = Department::where('id', $id)->first();

        if (!$event) {
            return response()->json(['error' => 'not exist department have this id'], 404);
        }

        Department::where('id', $id)->delete();

        return response()->json(['message' => 'department deleted in successfully'], 200);
    } //end delete


    //function for update department
    function update(AdminUpdateDepartmentRequest $request)
    {
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $department = Department::where('id', $request->department_id)->first();
        if (!$department) {
            return response()->json(['error' => 'not exist department have this id'], 404);
        } //end if

        Department::where('id', $request->department_id)->update(
            [
                "name" => $request->name ?: $department->name,
                'abbrevation' => $request->abbrevation ?: $department->abbrevation
            ]
        );

        return response()->json(['message' => 'department updated in successfully'], 201);
    } //end update

}//end DepartmentAdminController
