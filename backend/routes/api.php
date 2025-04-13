<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\auth\LoginController;

Route::group(['prefix' => 'auth'], function () {
    // Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
});