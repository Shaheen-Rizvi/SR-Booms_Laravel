<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
   public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'message' => 'Invalid login credentials',
            'suggestion' => 'Please check your email and password'
        ], 401);
    }

    $user = Auth::user();

    // Redirect logic based on user_type
    $redirectUrl = $user->user_type === 'admin' 
        ? route('admin.dashboard') 
        : route('user.dashboard');

    $token = $user->createToken('flower_shop_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'user_type' => $user->user_type,
        ],
        'redirect_url' => $redirectUrl,
        'token' => $token
    ]);
}


    public function logout(Request $request)
    {
        // Ensure user is authenticated before attempting to revoke tokens
        if ($request->user()) {
            // Revoke all tokens (for strict security)
            $request->user()->tokens()->delete();
            
            // Or revoke just the current token (more flexible)
            // $request->user()->currentAccessToken()->delete();
            
            return response()->json([
                'message' => 'Successfully logged out from all devices'
            ]);
        }
        
        return response()->json(['message' => 'No user authenticated.'], 401);
    }
}