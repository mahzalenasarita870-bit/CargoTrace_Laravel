<?php

use Illuminate\\Support\\Facades\\Route;
use App\\Http\\Controllers\\DashboardController;
use App\\Http\\Controllers\\ShipmentController;
use App\\Http\\Controllers\\TrackingController;

Route::get('/', fn () => redirect()->route('dashboard'));
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('shipments', ShipmentController::class);
    Route::get('/shipments/{shipment}/tracking', [TrackingController::class, 'index'])->name('tracking.index');
    Route::post('/shipments/{shipment}/tracking', [TrackingController::class, 'store'])->name('tracking.store');
});
require __DIR__.'/auth.php';
