<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\ExceptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportsController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::resource('shipments', ShipmentController::class)
        ->only(['index', 'create', 'store']);

    Route::resource('tracking', TrackingController::class)
    ->only(['index', 'create', 'store']);

    Route::resource('exceptions', ExceptionController::class)
    ->only(['index', 'create', 'store']);

    Route::patch('/exceptions/{exception}/resolve', [ExceptionController::class, 'resolve'])
        ->name('exceptions.resolve');

    Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');

    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])
        ->name('users.updateRole');

    Route::get('/reports', [ReportsController::class, 'index'])
    ->name('reports.index');

});
