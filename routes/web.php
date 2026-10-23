<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ResultController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\AdminAuthController;

Route::view('/', 'home')->name('home');


Route::get('/student/login', [StudentAuthController::class, 'showlogin'])->name('student.login');

Route::post('/student/login', [StudentAuthController::class, 'login'])->name('student.login.submit');

Route::get('/student/dashboard', [StudentAuthController::class, 'dashboard'])->name('student.dashboard');

Route::post('/student/logout', [StudentAuthController::class, 'logout'])->name('student.logout');


Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


Route::get('/student/results', [ResultController::class, 'studentResults'])->name('student.results');



Route::middleware('admin')->group(function() {
    Route::resource('students',StudentController::class);
    Route::resource('results', ResultController::class);
});







