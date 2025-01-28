<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', 'App\Http\Controllers\Api\AuthController@register');
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

Route::post('/login/google', [App\Http\Controllers\Api\AuthController::class, 'loginGoogle']);
Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/events', [App\Http\Controllers\Api\EventController::class, 'index']);
