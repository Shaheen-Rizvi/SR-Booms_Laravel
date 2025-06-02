<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function orders(Request $request)
    {
        return $request->user()->orders; // Adjust depending on relationship
    }

    public function favorites(Request $request)
    {
        return $request->user()->favorites; // Adjust depending on relationship
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $user->update($request->all());
        return response()->json(['message' => 'Profile updated successfully.']);
    }

    // Optional for Admin Panel
    public function index() {
        return User::all(); // Only if admin is listing users
    }
}
