<?php

declare(strict_types=1);

use App\Http\Controllers\Api\StatusController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->name('api.v1.')->middleware([])
    ->group(function (): void {
        Route::prefix('/statuses')->name('statuses.')->group(function (): void {
            Route::get('/', [StatusController::class, 'index'])->name('index');
            Route::get('/{id}', [StatusController::class, 'show'])->name('show')->whereNumber('id');
            Route::post('/', [StatusController::class, 'store'])->name('store');
            Route::put('/{id}', [StatusController::class, 'update'])->name('update')->whereNumber('id');
            Route::delete('/{id}', [StatusController::class, 'destroy'])->name('destroy')->whereNumber('id');
        });
    });
