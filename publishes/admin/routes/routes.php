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


    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');

    // Users
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/items', [UserController::class, 'items'])->name('user.items');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.delete');
    // User Profile
    Route::get('/user/profile', [UserProfileController::class, 'show'])->name('user.profile');
    Route::post('/user/profile/password', [UserProfileController::class, 'updatePassword'])->name('user.profile.password');

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
