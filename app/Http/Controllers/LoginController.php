<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // make sure you have a User model
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate request inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Find user by email
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 401);
        }

        // Check if password matches the hashed password in DB
        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // If you are using JWT Auth (e.g., tymon/jwt-auth), generate token here:
        // $token = auth()->login($user);

        // For now, just send a success message
        return response()->json(['message' => 'Login successful']);
    }
}
