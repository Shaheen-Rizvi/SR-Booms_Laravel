<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Use the 'admin' guard explicitly
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->user_type === 'admin') {
            return view('admin.dashboard'); // Return the admin dashboard view
        }

        abort(403, 'Unauthorized access');
    }
}
