<?php

use App\Http\Controllers\Auth\AuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/users', [AuthController::class, 'getUsers']);

Route::group(['middleware' => 'api'], function ($router) {
    Route::group(['prefix' => 'auth'], function() {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('users', [AuthController::class, 'getUsers']);
    });
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('menus', \App\Http\Controllers\MenuController::class);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('trails', \App\Http\Controllers\TrailController::class);
});
