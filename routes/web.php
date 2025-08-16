<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BKController;
use App\Http\Controllers\KesiswaanController;
use App\Http\Controllers\UserController;

// Auth Routes
Route::get('/', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Kesiswaan Routes
Route::prefix('kesiswaan')->name('kesiswaan.')->group(function () {
    Route::get('/dashboard', [KesiswaanController::class, 'index'])->name('dashboard');
    Route::match(['get', 'post'], '/recaps', [KesiswaanController::class, 'recaps'])->name('recaps');
    Route::post('/store', [KesiswaanController::class, 'store'])->name('violations.store');
    Route::post('/violations/{student}', [KesiswaanController::class, 'store'])->name('violations.store.student');
});

// BK Routes
Route::prefix('bk')->name('bk.')->group(function () {
    Route::get('/dashboard', [BKController::class, 'index'])->name('dashboard');
    Route::get('/student-violations/{studentId}', [BKController::class, 'getStudentViolations'])->name('student.violations');
    Route::put('/violation-status/{id}', [BKController::class, 'updateViolationStatus'])->name('violation.status.update');
});