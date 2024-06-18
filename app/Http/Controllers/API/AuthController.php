<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if(auth()->attempt($request->all())){

            $user = auth()->user();

            $token = $user->createToken('token')->plainTextToken;

            return SendResponse(200,'User Logged in successfully',['token' => $token]);
        }

        return SendResponse(401,'Incorrect password');
    }
}
