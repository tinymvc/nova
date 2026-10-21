<?php

use App\Http\Controllers\{DashboardController, ProfileController, ProjectController};
use App\Services\AccountService;
use Spark\Facades\Route;

Route::fire('/', 'welcome')
    ->name('home');

AccountService::routes(); // This will register the login, logout, and password reset routes.

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
