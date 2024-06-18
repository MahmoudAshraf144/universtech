<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class FactsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $count['students'] = User::where('type',false)->count();
        $count['professors'] = User::where('type',true)->count();
        $count['departmens'] = Department::count();

        return SendResponse(200,'Here are the facts',$count);
    }
}
