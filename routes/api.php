<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TourController;

Route::post('/login', [UserController::class, 'login']);
Route::post('/registration', [UserController::class, 'registration']);

Route::middleware('auth')->group(function () {
    Route::get('/me', [UserController::class, 'me']);

    Route::prefix('tour')->group(function (){
        Route::post('/create', [TourController::class, 'addTour']);
        Route::get('/{id}', [TourController::class, 'getTour'])->where(['id' => '[0-9]+']);
        Route::get('/', [TourController::class, 'getTours']);
        Route::delete('/{id}', [TourController::class, 'deleteTour'])->where(['id' => '[0-9]+']);
    });
});
