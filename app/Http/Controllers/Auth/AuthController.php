<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|max:255',
            'password' => 'required',
        ]);
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($credentials)) {
            $user = User::where('id', auth()->user()->id)->first();
            return response()->json([
                'user' => $user,
                'token' => $user->createToken('myapptoken')->plainTextToken,
            ],200);
        } else {
            return response()->json(['error' => 'Unauthenticated'], 404);
        }
    }
    
    public function logout()
    {
        // auth()->user()->tokens()->delete();
        return response()->json(['message' => "logged out"]);
    }
}
