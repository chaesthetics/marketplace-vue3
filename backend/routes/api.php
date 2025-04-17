<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\auth\LoginController;
use App\Http\Controllers\Api\ItemController; 
use App\Http\Controllers\Api\Auth\RegisterController;

Route::group(['prefix' => 'auth'], function () {
    // Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
    Route::post('/register', RegisterController::class);
});

Route::group(['middleware' => [
    'auth:sanctum',
]], function () {
    Route::apiResources([
        'items' => ItemController::class,
    ]);
});