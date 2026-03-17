<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/user',         [UserController::class, 'show']);
    Route::put('/user',         [UserController::class, 'update']);
});

Route::get('/health', fn() => response()->json(['status' => 'ok', 'timestamp' => now()]));
