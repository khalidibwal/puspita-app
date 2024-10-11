<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApiUser; // Ensure you have the User model imported
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; // Add this line
use Illuminate\Validation\ValidationException; // Import ValidationException

class AuthController extends Controller
{
     /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create new user
        $user = ApiUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password
        ]);

        // Generate token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return the token and user data
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 201);
    }

    /**
     * Login an existing user.
     */
    public function login(Request $request)
    {
        // Validate the login request
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Check if the user exists and password matches
        $user = ApiUser::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Generate token for the authenticated user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return the token and user data
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 200);
    }

    /**
     * Logout the authenticated user.
     */
    public function logout(Request $request)
    {
        // Revoke the current user's token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Fetch the authenticated user's profile.
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
