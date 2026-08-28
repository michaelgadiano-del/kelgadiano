<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

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