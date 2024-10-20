<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PersonController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/person')->group(function () {
    Route::get('/', [PersonController::class, 'getAll']);

    Route::get('/{id}', [PersonController::class, 'show']);

    Route::post('/', [PersonController::class, 'store']);

    Route::put('/{id}', [PersonController::class, 'update']);
    
    Route::delete('/{id}', [PersonController::class, 'destroy']);
});