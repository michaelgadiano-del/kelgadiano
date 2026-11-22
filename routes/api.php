<?php

use App\Http\Controllers\Api\V1\EmployeeApiController;
use App\Http\Controllers\Api\V1\TokenController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::post('/tokens', [TokenController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('api.v1.tokens.store');

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::delete('/tokens/current', [TokenController::class, 'destroy'])
            ->name('api.v1.tokens.destroy');
        Route::apiResource('employees', EmployeeApiController::class)
            ->names('api.v1.employees');
    });
});
