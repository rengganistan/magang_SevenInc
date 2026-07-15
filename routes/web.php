<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/



Route::get('/', function () {
    return redirect()->route('login');
});
//login
Route::get('/login', [LoginController::class, 'index'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.process');


// admin
Route::middleware(['auth','role:admin'])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->name('admin.dashboard');

    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');

    Route::get('/users/create', [UserController::class, 'create'])
        ->name('users.create');

    Route::post('/users', [UserController::class, 'store'])
        ->name('users.store');

});

Route::get('/manager/dashboard', [DashboardController::class, 'manager'])
    ->middleware(['auth', 'role:admin,manager'])
    ->name('manager.dashboard');

Route::get('/staff/dashboard', [DashboardController::class, 'staff'])
    ->middleware(['auth', 'role:admin,manager,staff'])
    ->name('staff.dashboard');
