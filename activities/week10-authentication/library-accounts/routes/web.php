<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('books.index'));
Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:librarian,admin')->group(function () {
        Route::resource('books', BookController::class)->except(['index', 'show']);
        Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
        Route::patch('/authors/{author}/name', [AuthorController::class, 'update'])->name('authors.update');
        Route::get('/desk', [LoanController::class, 'desk'])->name('desk')->middleware('can:viewAny,App\\Models\\Loan');
        Route::patch('/desk/loans/{loan}/return', [LoanController::class, 'markReturned'])->name('desk.loans.return');
    });

    Route::middleware('role:member')->group(function () {
        Route::get('/my/loans', [LoanController::class, 'myLoans'])->name('my.loans');
        Route::post('/books/{book}/borrow', [BookController::class, 'borrow'])->name('books.borrow');
    });

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
            Route::patch('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.role');
        });
});

Route::resource('books', BookController::class)->only(['index', 'show']);

require __DIR__.'/auth.php';
