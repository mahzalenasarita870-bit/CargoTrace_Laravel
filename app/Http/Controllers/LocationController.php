<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // Menampilkan daftar location
    public function index()
    {
        $locations = Location::latest()->paginate(10);

        return view('locations.index', compact('locations'));
    }

    // Menampilkan form tambah location
    public function create()
    {
        return view('locations.create');
    }

    // Menyimpan data location
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        Location::create([
            'name' => $request->name,
            'city' => $request->city,
            'country' => $request->country,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()
            ->route('locations.index')
            ->with('success', 'Data location berhasil ditambahkan.');
    }

    // Menampilkan form edit location
    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    // Memperbarui data location
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $location->update([
            'name' => $request->name,
            'city' => $request->city,
            'country' => $request->country,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()
            ->route('locations.index')
            ->with('success', 'Data location berhasil diperbarui.');
    }

    // Menghapus data location
    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()
            ->route('locations.index')
            ->with('success', 'Data location berhasil dihapus.');
    }
}
