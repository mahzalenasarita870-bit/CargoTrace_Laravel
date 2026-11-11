<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalShipments = Shipment::count();

        $inTransit = Shipment::where(
            'current_status',
            'IN_TRANSIT'
        )->count();

        $delivered = Shipment::where(
            'current_status',
            'DELIVERED'
        )->count();

        $delayed = Shipment::where(
            'current_status',
            'DELAYED'
        )->count();

        $recentShipments = Shipment::with([
            'customer',
            'carrier',
            'origin',
            'destination'
        ])->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalShipments',
            'inTransit',
            'delivered',
            'delayed',
            'recentShipments'
        ));
    }
}