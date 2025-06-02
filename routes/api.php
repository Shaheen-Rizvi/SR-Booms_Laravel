<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FlowerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;

Route::middleware('api')->group(function () {
    // Public Auth Routes
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    // Public Flower Catalog
    Route::get('/flowers', [FlowerController::class, 'index']);
    Route::get('/flowers/{flower}', [FlowerController::class, 'show']);
    Route::get('/flowers/category/{category}', [FlowerController::class, 'byCategory']);
    Route::get('/featured-flowers', [FlowerController::class, 'featured']);

    // Public Categories
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);

    // Protected Routes (user or admin)
    Route::middleware('auth:sanctum')->group(function () {

        // General Auth Actions
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', fn(Request $request) => $request->user());

        // Logged-in User Routes
        Route::prefix('user')->group(function () {
            Route::get('/orders', [UserController::class, 'orders']);
            Route::get('/favorites', [UserController::class, 'favorites']);
            Route::put('/profile', [UserController::class, 'updateProfile']);
        });

        // User Order Routes
        Route::apiResource('orders', OrderController::class)->except(['index', 'destroy']);

        // Favorites
        Route::post('/flowers/{flower}/favorite', [FavoriteController::class, 'store']);
        Route::delete('/flowers/{flower}/favorite', [FavoriteController::class, 'destroy']);

        // Reviews
        Route::apiResource('flowers.reviews', ReviewController::class)->shallow()->only(['store', 'update', 'destroy']);

        // Admin-only routes
        Route::middleware('admin')->group(function () {
            // Flowers
            Route::post('/flowers', [FlowerController::class, 'store']);
            Route::put('/flowers/{flower}', [FlowerController::class, 'update']);
            Route::delete('/flowers/{flower}', [FlowerController::class, 'destroy']);

            // Categories
            Route::post('/categories', [CategoryController::class, 'store']);
            Route::put('/categories/{category}', [CategoryController::class, 'update']);
            Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

            // Admin managing users
            Route::apiResource('users', UserController::class)->except(['store']); // Admin can view/delete/update users

            // Admin managing orders
            Route::get('/all-orders', [OrderController::class, 'index']);
            Route::delete('/orders/{order}', [OrderController::class, 'destroy']);
        });
    });
});
