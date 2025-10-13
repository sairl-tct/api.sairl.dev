<?php

declare(strict_types=1);

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->name('api.v1.')->middleware([])
    ->group(function (): void {

        Route::prefix('/categories')->name('categories.')->group(function (): void {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/{slug}', [CategoryController::class, 'show'])->name('show')->whereAlpha('slug');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::delete('/{slug}', [CategoryController::class, 'destroy'])->name('destroy')->whereAlpha('slug');
        });

    });
