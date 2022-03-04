<?php

use {{ namespace }}\Http\Controllers\Auth\AuthenticatedSessionController;
use {{ namespace }}\Http\Controllers\Auth\NewPasswordController;
use {{ namespace }}\Http\Controllers\Auth\PasswordResetLinkController;
use {{ namespace }}\Http\Controllers\HomeController;
use {{ namespace }}\Http\Middleware\Authenticate{{ namespace }};
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => Authenticate{{ namespace }}::class,
], function () {
    Route::get('/', [HomeController::class, 'show']);
});

Route::group([
    'middleware' => 'guest',
], function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});