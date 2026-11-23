<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\ShipmentException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $shipmentQuery = Shipment::query();

        if ($user->isCustomer()) {
            $shipmentQuery->where('customer_id', $user->id);
        }

        $totalShipments = (clone $shipmentQuery)->count();
        $inTransit      = (clone $shipmentQuery)->where('current_status', 'IN_TRANSIT')->count();
        $delivered      = (clone $shipmentQuery)->where('current_status', 'DELIVERED')->count();
        $delayed        = (clone $shipmentQuery)->where('is_delayed', true)->count();

        $openExceptions = ShipmentException::whereIn('status', ['OPEN', 'INVESTIGATING'])
            ->when($user->isCustomer(), function ($q) use ($user) {
                $q->whereHas('shipment', fn ($sq) => $sq->where('customer_id', $user->id));
            })
            ->count();

        $delayRate = $totalShipments > 0 ? round(($delayed / $totalShipments) * 100, 1) : 0;

        $shipmentsWithException = (clone $shipmentQuery)->whereHas('exceptions')->count();
        $exceptionRate = $totalShipments > 0 ? round(($shipmentsWithException / $totalShipments) * 100, 1) : 0;

        $byStatus = (clone $shipmentQuery)
            ->select('current_status', DB::raw('count(*) as total'))
            ->groupBy('current_status')
            ->pluck('total', 'current_status')
            ->toArray();

        $byCarrier = (clone $shipmentQuery)
            ->join('carriers', 'shipments.carrier_id', '=', 'carriers.id')
            ->select('carriers.name', DB::raw('count(shipments.id) as total'))
            ->groupBy('carriers.name')
            ->pluck('total', 'name')
            ->toArray();

        $recentShipments = (clone $shipmentQuery)
            ->with(['customer', 'carrier', 'origin', 'destination'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalShipments',
            'inTransit',
            'delivered',
            'delayed',
            'openExceptions',
            'delayRate',
            'exceptionRate',
            'byStatus',
            'byCarrier',
            'recentShipments'
        ));
    }
}