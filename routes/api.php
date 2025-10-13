<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\RegisteredUserController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->name('api.v1.')->middleware([])
    ->group(function (): void {

        Route::prefix('auth')->name('auth.')->group(function (): void {

            Route::post('/signIn', [App\Http\Controllers\Api\Auth\SignInUserController::class, 'store'])->name('signIn');
            Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

        });

        Route::middleware([])->prefix('/categories')->name('categories.')->group(function (): void {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/{slug}', [CategoryController::class, 'show'])->name('show')->whereAlpha('slug');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::delete('/{slug}', [CategoryController::class, 'destroy'])->name('destroy')->whereAlpha('slug');
        });

    });
