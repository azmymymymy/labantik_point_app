<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BKController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [App\Http\Controllers\UserController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\UserController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');

Route::get('kesiswaan/dashboard', [App\Http\Controllers\KesiswaanController::class, 'index'])->name('dashboard');
Route::match(['get', 'post'], 'kesiswaan/recaps', [App\Http\Controllers\KesiswaanController::class, 'recaps'])
    ->name('recaps');
Route::get('bk/dashboard', [App\Http\Controllers\BKController::class, 'index'])->name('dashboard');

Route::post('/kesiswaan/store', [App\Http\Controllers\KesiswaanController::class, 'store'])->name('violations.store');
Route::post('/violations/{student}', [App\Http\Controllers\KesiswaanController::class, 'store'])->name('violations.store');

// BK Dashboard Routes
Route::prefix('bk')->name('bk.')->group(function () {
    Route::get('/dashboard', [BKController::class, 'index'])->name('dashboard');
    Route::get('/student-violations/{studentId}', [BKController::class, 'getStudentViolations'])->name('student.violations');

    // PERBAIKAN: Tambahkan name prefix 'bk.' agar konsisten
    Route::put('/violation-status/{id}', [BKController::class, 'updateViolationStatus'])->name('violation-status.update');
});
