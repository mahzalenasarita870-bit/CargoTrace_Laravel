<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ResourceApiController;
use App\Http\Controllers\Api\ShipmentApiController;
use Illuminate\Support\Facades\Route;

// Public Auth Endpoints
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

// Protected Sanctum Endpoints
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/user', [AuthApiController::class, 'user']);

    // Shipments
    Route::get('/shipments', [ShipmentApiController::class, 'index']);
    Route::post('/shipments', [ShipmentApiController::class, 'store']);
    Route::get('/shipments/{shipment}', [ShipmentApiController::class, 'show']);
    Route::match(['put', 'patch'], '/shipments/{shipment}', [ShipmentApiController::class, 'update']);
    Route::delete('/shipments/{shipment}', [ShipmentApiController::class, 'destroy']);

    // Tracking Events
    Route::get('/shipments/{shipment}/tracking', [ShipmentApiController::class, 'trackingIndex']);
    Route::post('/shipments/{shipment}/tracking', [ShipmentApiController::class, 'trackingStore']);

    // Shipment Exceptions
    Route::get('/shipments/{shipment}/exceptions', [ShipmentApiController::class, 'exceptionIndex']);
    Route::post('/shipments/{shipment}/exceptions', [ShipmentApiController::class, 'exceptionStore']);
    Route::patch('/exceptions/{exception}', [ShipmentApiController::class, 'exceptionUpdate']);

    // Carriers & Locations
    Route::get('/carriers', [ResourceApiController::class, 'carriersIndex']);
    Route::post('/carriers', [ResourceApiController::class, 'carriersStore']);
    Route::get('/locations', [ResourceApiController::class, 'locationsIndex']);
    Route::post('/locations', [ResourceApiController::class, 'locationsStore']);
});