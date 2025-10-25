<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\RegisteredUserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->name('api.v1.')->middleware([])
    ->group(function (): void {

        Route::prefix('auth')->name('auth.')->group(function (): void {

            Route::post('/signIn', [App\Http\Controllers\Api\Auth\SignInUserController::class, 'store'])->name('signIn');
            Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

        });

        Route::prefix('/categories')->name('categories.')->group(function (): void {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/{slug}', [CategoryController::class, 'show'])->name('show')->whereAlpha('slug');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::put('/{slug}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{slug}', [CategoryController::class, 'destroy'])->name('destroy')->whereAlpha('slug');
        });

        Route::prefix('/statuses')->name('statuses.')->group(function (): void {
            Route::get('/', [StatusController::class, 'index'])->name('index');
            Route::get('/{id}', [StatusController::class, 'show'])->name('show')->whereNumber('id');
            Route::post('/', [StatusController::class, 'store'])->name('store');
            Route::put('/{id}', [StatusController::class, 'update'])->name('update')->whereNumber('id');
            Route::delete('/{id}', [StatusController::class, 'destroy'])->name('destroy')->whereNumber('id');
        });

        Route::prefix('/roles')->name('roles.')->group(function (): void {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/{id}', [RoleController::class, 'show'])->name('show')->whereNumber('id');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::put('/{id}', [RoleController::class, 'update'])->name('update')->whereNumber('id');
            Route::delete('/{id}', [RoleController::class, 'destroy'])->name('destroy')->whereNumber('id');
        });

        Route::prefix('/permissions')->name('permissions.')->group(function (): void {
            Route::get('/', [PermissionController::class, 'index'])->name('index');
            Route::get('/{id}', [PermissionController::class, 'show'])->name('show')->whereNumber('id');
            Route::post('/', [PermissionController::class, 'store'])->name('store');
            Route::put('/{id}', [PermissionController::class, 'update'])->name('update')->whereNumber('id');
            Route::delete('/{id}', [PermissionController::class, 'destroy'])->name('destroy')->whereNumber('id');
        });
        Route::prefix('/tags')->name('tag.')->group(function (): void {
            Route::get('/', [TagController::class, 'index'])->name('index');
            Route::get('/{id}', [TagController::class, 'show'])->name('show')->whereNumber('id');
            Route::post('/', [TagController::class, 'store'])->name('store');
            Route::put('/{id}', [TagController::class, 'update'])->name('update')->whereNumber('id');
            Route::delete('/{id}', [TagController::class, 'destroy'])->name('destroy')->whereNumber('id');
        });
    });
