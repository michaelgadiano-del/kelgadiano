<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('courses.index'));
Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('courses', CourseController::class)->except(['index', 'show']);
});

Route::resource('courses', CourseController::class)->only(['index', 'show']);

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', function () {
            $users = User::withCount('courses')->orderBy('role')->orderBy('name')->get();

            return view('admin.index', compact('users'));
        })->name('index');
        Route::patch('/users/{user}/name', [AdminUserController::class, 'updateInstructorName'])
            ->name('users.name');
    });

require __DIR__.'/auth.php';
