<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowBookController;
use App\Http\Controllers\MemberRegistrationController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/books');
Route::resource('books', BookController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update']);
Route::get('/register', [MemberRegistrationController::class, 'create'])->name('members.create');
Route::post('/members', [MemberRegistrationController::class, 'store'])->name('members.store');
Route::post('/books/{book}/borrow', [BorrowBookController::class, 'store'])->name('books.borrow');
