<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(['message' => 'Invalid credentials'],422);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('booking-api', ['*'], now()->addHours(4))->plainTextToken; // change to 2

        return response()->json([
            'message' => 'Logged In',
            'api-token' => $token
        ]);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged Out'
        ]);
    }
}
