<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\ExceptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\LocationController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::middleware('auth')->group(function () {

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

Route::get('/shipments', [ShipmentController::class, 'index'])
    ->name('shipments.index');

Route::get('/shipments/create', [ShipmentController::class, 'create'])
    ->name('shipments.create');

Route::post('/shipments', [ShipmentController::class, 'store'])
    ->name('shipments.store');

Route::get('/shipments/{shipment}/edit', [ShipmentController::class, 'edit'])
    ->name('shipments.edit');

Route::put('/shipments/{shipment}', [ShipmentController::class, 'update'])
    ->name('shipments.update');

Route::delete('/shipments/{shipment}', [ShipmentController::class, 'destroy'])
    ->name('shipments.destroy');
    
    Route::resource('tracking', TrackingController::class)
        ->only(['index', 'create', 'store']);

    Route::get('/tracking/{shipment}/history', [TrackingController::class, 'history'])
        ->name('tracking.history');

    Route::get('/tracking/search', [TrackingController::class, 'search'])
    ->name('tracking.search');

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

    Route::get('/reports/export-pdf', [ReportsController::class, 'exportPdf'])
    ->name('reports.exportPdf');


    Route::get('/reports/export-excel', [ReportsController::class, 'exportExcel'])
        ->name('reports.exportExcel');

    // ROUTE CARRIERS
    Route::get('/carriers', [CarrierController::class, 'index'])
        ->name('carriers.index');

    Route::get('/carriers/create', [CarrierController::class, 'create'])
        ->name('carriers.create');

    Route::post('/carriers', [CarrierController::class, 'store'])
        ->name('carriers.store');

    
    Route::get('/carriers/{carrier}/edit', [CarrierController::class, 'edit'])
        ->name('carriers.edit');

    Route::put('/carriers/{carrier}', [CarrierController::class, 'update'])
        ->name('carriers.update');
    
    
    Route::delete('/carriers/{carrier}', [CarrierController::class, 'destroy'])
        ->name('carriers.destroy');



    // ROUTE LOCATIONS

    Route::get('/locations', [LocationController::class, 'index'])
        ->name('locations.index');

    Route::get('/locations/create', [LocationController::class, 'create'])
        ->name('locations.create');

    Route::post('/locations', [LocationController::class, 'store'])
        ->name('locations.store');

    Route::get('/locations/{location}/edit', [LocationController::class, 'edit'])
        ->name('locations.edit');

    Route::put('/locations/{location}', [LocationController::class, 'update'])
        ->name('locations.update');

    Route::delete('/locations/{location}', [LocationController::class, 'destroy'])
        ->name('locations.destroy');

});
