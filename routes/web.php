<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [App\Http\Controllers\UserController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\UserController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');

Route::get('/dashboard', [App\Http\Controllers\KesiswaanController::class, 'index'])->name('dashboard');

Route::post('/kesiswaan/store', [App\Http\Controllers\KesiswaanController::class, 'store'])->name('violations.store');
Route::post('/violations/{student}', [App\Http\Controllers\KesiswaanController::class, 'store'])->name('violations.store');
