<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'))->name('home');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1')->name('register.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/contact', [PageController::class, 'contact'])
    ->name('contact.show');

Route::get('/items/{id}', [ItemController::class, 'show'])
    ->whereNumber('id')
    ->name('items.show');

Route::get('/feedback', [FeedbackController::class, 'create'])
    ->name('feedback.form');

Route::post('/feedback', [FeedbackController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('feedback.submit');

Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy'])
    ->name('feedback.delete');

Route::resource('students', StudentController::class);
Route::resource('courses', CourseController::class);
Route::resource('employees', EmployeeController::class)->middleware('auth');
