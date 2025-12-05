<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated= $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if(!$validated){
            return response()->json(['error' => $validated], 400);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at' => now(),
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['message' => 'User registered successfully', 'user' => $user, 'token' => $token], 201);
        } catch (\Throwable $th) {
            return response()->json(['error'=> 'Failed to register user', 'details' => $th->getMessage()], 500);
        }
    }
}
