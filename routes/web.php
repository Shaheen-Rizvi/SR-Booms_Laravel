<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\UserController;
use App\Models\Order;
use App\Models\Flower;
use App\Livewire\AdminLogin;
use App\Livewire\UserLogin;
use App\Livewire\UserDashboard;
use App\Livewire\AdminDashboard;
use App\Http\Controllers\FlowerController;
use App\Http\Controllers\FirebaseTestController;



Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', UserLogin::class)->name('login');
Route::get('/admin/login', AdminLogin::class)->name('admin.login');

// User dashboard (only for users)
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', UserDashboard::class)->name('user.dashboard');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});

/*// Admin dashboard (only for admins)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::post('/admin/logout', [AdminLoginController::class, 'destroy'])->name('admin.logout');
});
*/
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');         // GET /user
    Route::get('/{user}', [UserController::class, 'show'])->name('user.show');     // GET /user/{user}
    Route::put('/{user}', [UserController::class, 'update'])->name('user.update'); // PUT /user/{user}
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('user.destroy'); // DELETE /user/{user}
});

Route::get('/login', UserLogin::class)->name('login');
Route::get('/admin/login', AdminLogin::class)->name('admin.login');

// User routes with web guard and 'user' middleware
Route::middleware(['auth:web'])->group(function () {
    Route::get('/user/dashboard', UserDashboard::class)->name('user.dashboard');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});

// Admin routes with admin guard and 'admin' middleware
Route::middleware(['auth:admin', 'admin'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::post('/admin/logout', [AdminLoginController::class, 'destroy'])->name('admin.logout');
});

Route::get('/flowers', [FlowerController::class, 'index'])->name('flowers.index');;

// Your existing routes...
Route::get('/', function () {
    return view('welcome');
});



// Firebase Test Route
Route::get('/test-firebase', function() {
    $firebase = app()->make(\App\Services\FirebaseService::class);
    $database = $firebase->getDatabase();
    
    try {
        // Test write
        $database->getReference('test')->set(['message' => 'Firebase is working!']);
        
        // Test read
        $value = $database->getReference('test/message')->getValue();
        
        return response()->json([
            'status' => 'success',
            'message' => $value
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

// Fallback route (if any)
Route::fallback(function () {
    //
});

Route::get('/test-firebase', [FirebaseTestController::class, 'test']);