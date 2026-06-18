<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group Authentication
 * 
 * APIs untuk autentikasi user
 */
class AuthController extends Controller
{
    /**
     * Login User
     * 
     * Melakukan autentikasi user dan mengembalikan token akses.
     * 
     * @bodyParam email string required Email user. Example: "john@example.com"
     * @bodyParam password string required Password user. Example: "password"
     * 
     * @response 200 {
     *   "access_token": "1|laravel_sanctum_token_value...",
     *   "token_type": "Bearer"
     * }
     * @response 401 {
     *   "message": "Credentials do not match"
     * }
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Credentials do not match'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
