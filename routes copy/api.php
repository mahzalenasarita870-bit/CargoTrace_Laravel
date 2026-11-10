<?php

use Illuminate\\Support\\Facades\\Route;
use App\\Http\\Controllers\\Api\\ShipmentApiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('shipments', ShipmentApiController::class);
    Route::get('/shipments/{shipment}/tracking', [ShipmentApiController::class, 'tracking']);
});
