<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\ShipmentException;
use Illuminate\Http\Request;

class ExceptionController extends Controller
{
    public function index()
    {
        $exceptions = ShipmentException::with([
            'shipment',
            'resolver'
        ])
        ->latest('detected_at')
        ->paginate(10);

        return view('exceptions.index', compact('exceptions'));
    }

    public function create()
    {
        $shipments = Shipment::all();

        return view('exceptions.create', compact('shipments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipment_id' => 'required|exists:shipments,id',
            'exception_type' => 'required|string|max:255',
            'severity' => 'required|in:LOW,MEDIUM,HIGH,CRITICAL',
            'description' => 'required|string',
            'detected_at' => 'required|date',
        ]);

        $validated['status'] = 'OPEN';

        ShipmentException::create($validated);

        return redirect()
            ->route('exceptions.index')
            ->with('success', 'Exception berhasil ditambahkan.');
    }

    public function resolve(ShipmentException $exception)
    {
        if ($exception->status !== 'RESOLVED') {
            $exception->update([
                'status' => 'RESOLVED',
                'resolved_at' => now(),
                'resolved_by' => auth()->id(),
            ]);
        }

        return redirect()
            ->route('exceptions.index')
            ->with('success', 'Exception berhasil diselesaikan.');
    }
}
