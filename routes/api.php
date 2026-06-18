<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/categories', function () {
    return ['Technology', 'Health', 'Lifestyle', 'Education'];
});

// Public Notes Routes (Read-only)
Route::get('/notes', [NoteController::class, 'index']);
Route::get('/notes/{note}', [NoteController::class, 'show']);

// Public Users Routes (Register)
Route::post('/users', [UserController::class, 'store']);

// Protected Routes (Require Sanctum Authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Notes management
    Route::post('/notes', [NoteController::class, 'store']);
    Route::put('/notes/{note}', [NoteController::class, 'update']);
    Route::delete('/notes/{note}', [NoteController::class, 'destroy']);

    // Users management
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
});


