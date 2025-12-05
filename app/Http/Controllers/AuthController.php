<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {


        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            if (!$validated) {
                return response()->json(['error' => $validated], 400);
            }
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'email_verified_at' => now(),
                'password' => Hash::make($validated['password']),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['message' => 'User registered successfully', 'user' => $user, 'token' => $token], 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Failed to register user', 'details' => $th->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {

        try {
            $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user,
            'token' => $token], 200);
        } catch (\Throwable $th) {
            \Log::error('Login error: ' . $th->getMessage());
            return response()->json(['error' => 'Failed to login user', 'details' => $th->getMessage()], 500);
        }


    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'User logged out successfully'], 200);
    }
}
