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
use App\Models\AuditLog;
use App\Models\AppNotification;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Akses Bersama: Admin, Operator, dan Customer (Shipment di-filter via Policy/Controller)
    Route::get('/shipments', [ShipmentController::class, 'index'])->name('shipments.index');
    Route::get('/shipments/{shipment}', [ShipmentController::class, 'show'])
        ->whereNumber('shipment')
        ->name('shipments.show');
    Route::get('/tracking/{shipment}/history', [TrackingController::class, 'history'])->name('tracking.history');

    // Notifikasi In-App
    Route::get('/notifications', function () {
        $notifications = AppNotification::where('user_id', auth()->id())->latest()->paginate(15);
        return view('notifications.index', compact('notifications'));
    })->name('notifications.index');

    Route::patch('/notifications/{notification}/read', function (AppNotification $notification) {
        abort_if($notification->user_id !== auth()->id(), 403);
        $notification->update(['read_at' => now()]);
        return back();
    })->name('notifications.read');

    // Akses Operasional: Khusus Admin & Logistics Operator
    Route::middleware('role:admin,operator')->group(function () {
        Route::get('/shipments/create', [ShipmentController::class, 'create'])->name('shipments.create');
        Route::post('/shipments', [ShipmentController::class, 'store'])->name('shipments.store');
        Route::get('/shipments/{shipment}/edit', [ShipmentController::class, 'edit'])->name('shipments.edit');
        Route::put('/shipments/{shipment}', [ShipmentController::class, 'update'])->name('shipments.update');

        Route::resource('tracking', TrackingController::class)->only(['index', 'create', 'store']);
        Route::get('/tracking/search', [TrackingController::class, 'search'])->name('tracking.search');

        Route::resource('exceptions', ExceptionController::class)->only(['index', 'create', 'store']);
        Route::patch('/exceptions/{exception}/resolve', [ExceptionController::class, 'resolve'])->name('exceptions.resolve');

        Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
        Route::get('/reports/export-pdf', [ReportsController::class, 'exportPdf'])->name('reports.exportPdf');
        Route::get('/reports/export-excel', [ReportsController::class, 'exportExcel'])->name('reports.exportExcel');
    });

    // Akses Master Data & Konfigurasi: Khusus Administrator
    Route::middleware('role:admin')->group(function () {
        Route::delete('/shipments/{shipment}', [ShipmentController::class, 'destroy'])->name('shipments.destroy');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');

        Route::resource('carriers', CarrierController::class)->except(['show']);
        Route::resource('locations', LocationController::class)->except(['show']);

        Route::get('/audit-logs', function () {
            $logs = AuditLog::with('user')->latest()->paginate(20);
            return view('audit_logs.index', compact('logs'));
        })->name('audit-logs.index');
    });
});