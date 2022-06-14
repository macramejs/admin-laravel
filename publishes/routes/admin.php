<?php

use Admin\Http\Controllers\Auth\AuthenticatedSessionController;
use Admin\Http\Controllers\Auth\NewPasswordController;
use Admin\Http\Controllers\Auth\PasswordResetLinkController;
use Admin\Http\Controllers\HomeController;
use Admin\Http\Controllers\UserProfileController;
use Admin\Http\Controllers\UserController;
use Admin\Http\Controllers\SettingController;
use Admin\Http\Middleware\AuthenticateAdmin;
use Admin\Http\Controllers\MediaCollectionController;
use Admin\Http\Controllers\MediaController;
use Admin\Http\Controllers\PageController;
use Admin\Http\Controllers\NavController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => AuthenticateAdmin::class,
    'prefix' => 'api',
], function () {

    // settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');

    // profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');    

    // users
    Route::get('/users', [UserController::class, 'items'])->name('user.items');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.delete');

    // media
    Route::get('/media/items', [MediaController::class, 'items'])->name('media.items');
    Route::get('/media/{file}', [MediaController::class, 'item'])->name('media.item');
    Route::post('/media/upload', [MediaController::class, 'upload'])->name('media.upload');
    Route::post('/media/delete', [MediaController::class, 'destroy'])->name('media.destroy');

    // media collections
    Route::get('/media-collections', [MediaCollectionController::class, 'items'])->name('media-collections.items');
    Route::get('/media-collections/{collection}', [MediaCollectionController::class, 'show'])->name('media-collections.show');
    Route::post('/media-collections', [MediaCollectionController::class, 'store'])->name('media-collections.show');
    Route::post('/media-collections/{collection}/upload', [MediaCollectionController::class, 'upload'])->name('media-collections.upload');
    Route::post('/media-collections/{collection}/remove', [MediaCollectionController::class, 'remove'])->name('media-collections.remove');
    Route::post('/media-collections/{collection}/add', [MediaCollectionController::class, 'add'])->name('media-collections.add');
    Route::delete('/media-collections/{collection}', [MediaCollectionController::class, 'destroy'])->name('media-collections.destroy');

    // pages
    Route::get('/pages', [PageController::class, 'items'])->name('pages.items');
    Route::get('/pages/tree', [PageController::class, 'tree'])->name('pages.tree');
    Route::get('/pages/links', [PageController::class, 'links'])->name('pages.links');
    Route::get('/pages/{page}', [PageController::class, 'item'])->name('pages.item');
    Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
    Route::post('/pages/order', [PageController::class, 'order'])->name('pages.order');
    Route::post('/pages/{page}/meta', [PageController::class, 'meta'])->name('pages.meta');
    Route::post('/pages/{page}/upload', [PageController::class, 'upload'])->name('pages.upload');
    Route::post('/pages/{page}/duplicate', [PageController::class, 'duplicate'])->name('pages.duplicate');
    Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');
    Route::delete('/pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');

    // nav
    Route::get('/nav', [NavController::class, 'types'])->name('nav.types');
    Route::get('/nav/{type}/tree', [NavController::class, 'show'])->name('nav.tree');
    Route::post('/nav/{type}', [NavController::class, 'store'])->name('nav.store');
    Route::post('/nav/{type}/order', [NavController::class, 'order'])->name('nav.order');
    Route::put('/nav/{type}/{item}', [NavController::class, 'update'])->name('nav.update');
    Route::delete('/nav/{type}/{item}', [NavController::class, 'destroy'])->name('nav.item.delete');
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
