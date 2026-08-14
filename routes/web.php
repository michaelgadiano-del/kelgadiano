<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Requests\FeedbackRequest;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

// Model binding: implicit binding resolves {user} to a User model by id
Route::get('/students/{user}', [StudentController::class, 'show'])->name('students.show');
Route::get('/students', [StudentController::class, 'index'])->name('students.index');

// Parameter constraint example: only numbers allowed for {id}
Route::get('/items/{id}', function (string $id) {
    return "Item {$id}";
})->whereNumber('id');

// Contact view
Route::view('/contact', 'contact')->name('contact.show');

// Feedback form (GET) and submission (POST) using a FormRequest for validation
Route::get('/feedback', function () {
    return view('feedback');
})->name('feedback.form');

Route::post('/feedback', function (FeedbackRequest $request) {
    $data = $request->validated();
    return 'Feedback received: ' . ($data['message'] ?? '');
})->name('feedback.submit');
