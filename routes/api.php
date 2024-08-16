<?php

use App\Http\Controllers\EntityController;
use App\Http\Controllers\FiberController;
use App\Http\Controllers\FiberMarkerController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\MarkerController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::resource('users', UserController::class);
        Route::post('logout', [UserController::class, 'logout']);
        Route::post('exist-session', [UserController::class, 'existSession']);

        Route::resource('entities', EntityController::class);
        Route::resource('fibers', FiberController::class);
        Route::resource('maps', MapController::class);
        Route::resource('fibers', FiberController::class);
        Route::resource('fiber_markers', FiberMarkerController::class);

        Route::resource('markers', MarkerController::class);
        Route::put('move-marker/{id}', [MarkerController::class, 'move']);
    });

    // users
    Route::post('login', [UserController::class, 'login']);
});

// Not Found
Route::fallback(function () {
    return response()->json(['Not Found!'], 404);
});
