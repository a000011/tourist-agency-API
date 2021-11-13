<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User;

Route::post('/login', [User::class, 'login']);

Route::post('/registration', [User::class, 'registration']);

Route::middleware('auth')->group(function () {
    Route::get('/me', [User::class, 'me']);
});
