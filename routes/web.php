<?php

declare(strict_types=1);
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request): void {
    $request->fulfill();
})->middleware(['auth', 'signed'])->name('verification.verify');
