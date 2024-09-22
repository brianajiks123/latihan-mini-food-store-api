<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return new UserResource($request->user());
})->middleware('auth:sanctum');

// User Must Be Login
Route::middleware('auth:sanctum')->group(function() {
    // User
    Route::apiResource('users', UserApiController::class, array('as' => 'api'));

    // Logout
    Route::get('logout', [AuthApiController::class, 'logout']);
});

// Auth
Route::post('register', [AuthApiController::class, 'register']);
Route::post('login', [AuthApiController::class, 'login']);

// Categories
Route::get('categories', [CategoryApiController::class, 'index']);
