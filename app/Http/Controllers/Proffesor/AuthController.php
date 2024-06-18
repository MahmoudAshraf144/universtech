<?php

namespace App\Http\Controllers\Proffesor;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        // Fetch the user by email
        $user = User::where('email', $request->email)->first();

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
        } else {
            // Return an error if the password does not match
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


    // Return an unauthorized error if authentication fails
    public function logout(Request $request)
    {
        $professor = $request->user();

        if (!$professor) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if

        $professor->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    
    public function me(Request $request)
    {
        $professor = $request->user();

        if (!$professor) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } //end if
        return response()->json($professor);
    }
}
