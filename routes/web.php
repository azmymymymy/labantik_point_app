<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [App\Http\Controllers\UserController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\UserController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');