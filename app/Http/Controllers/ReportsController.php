<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $query = Shipment::query();

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('current_status', $request->status);
        }

        // Filter berdasarkan tanggal mulai
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        // Filter berdasarkan tanggal akhir
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $shipments = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Ringkasan laporan
        $totalShipments = Shipment::count();

        $created = Shipment::where('current_status', 'CREATED')->count();

        $inTransit = Shipment::where('current_status', 'IN_TRANSIT')->count();

        $delivered = Shipment::where('current_status', 'DELIVERED')->count();

        $delayed = Shipment::where('current_status', 'DELAYED')->count();

        return view('reports.index', compact(
            'shipments',
            'totalShipments',
            'created',
            'inTransit',
            'delivered',
            'delayed'
        ));
    }
}
