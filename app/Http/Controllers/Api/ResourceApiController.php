<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carrier;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResourceApiController extends Controller
{
    public function carriersIndex(): JsonResponse
    {
        return response()->json(Carrier::paginate(20), 200);
    }

    public function carriersStore(Request $request): JsonResponse
    {
        abort_unless($request->user()->isAdmin(), 403, 'Only administrators can create carriers.');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:carriers,code',
            'mode' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email',
        ]);

        $carrier = Carrier::create($validated);

        return response()->json(['data' => $carrier], 201);
    }

    public function locationsIndex(): JsonResponse
    {
        return response()->json(Location::paginate(20), 200);
    }

    public function locationsStore(Request $request): JsonResponse
    {
        abort_unless($request->user()->isAdmin(), 403, 'Only administrators can create locations.');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:locations,code',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $location = Location::create($validated);

        return response()->json(['data' => $location], 201);
    }
}