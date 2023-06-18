<?php

use App\Http\Controllers\Api\{RegisterController, LoginController, LogoutController, UserController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');
Route::post('/logout', LogoutController::class)->name('logout');

Route::get('/user', [UserController::class, 'getUser'])->name('user')->middleware('auth:api');
