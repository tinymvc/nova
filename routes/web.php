<?php

use App\Http\Controllers\Auth\{
    AuthenticatedSessionController,
    NewPasswordController,
    RegisteredUserController
};
use App\Http\Controllers\{DashboardController, ProfileController, ProjectController};
use Spark\Facades\Route;

Route::fire('/', 'welcome')
    ->name('home');

Route::group(['middleware' => 'guest'], function () {
    Route::fire('/login', 'auth.login')
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:10,1');

    Route::fire('/register', 'auth.register')
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('throttle:10,1');

    Route::fire('/forgot-password', 'auth.forgot-password')
        ->name('password.request');

    Route::post('/forgot-password', [NewPasswordController::class, 'link'])
        ->name('password.email')
        ->middleware('throttle:5,1');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'request'])
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'reset'])
        ->name('password.update')
        ->middleware('throttle:10,1');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/projects', [ProjectController::class, 'store'])
        ->name('projects.store');

    Route::patch('/projects/{id}', [ProjectController::class, 'update'])
        ->name('projects.update');

    Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])
        ->name('projects.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::put('/password', [ProfileController::class, 'password'])
        ->name('profile.password')
        ->middleware('throttle:10,1');
});
