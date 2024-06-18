<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{

    public function login(AdminLoginRequest $request)
    {
        // Fetch the user by email
        $user = Admin::where('email', $request->email)->first();

        // Check if user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Check if the provided password matches the user's password
        if (Hash::check($request->password, $user->password)) {
            // Create a new personal access token for the user
            $token = $user->createToken('token')->plainTextToken;

            // Return the token and user information
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ]);
        }//end if
        else {
            // Return an error if the password does not match
            return response()->json(['error' => 'Unauthorized'], 401);
        }//end else
    }//end login'

    public function logout(Request $request)
    {

        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $admin->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function me(Request $request)
    {
        $admin = $request->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        return response()->json($request->user());
    }

}//end AdminAuthController
