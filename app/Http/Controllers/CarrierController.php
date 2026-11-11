<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use Illuminate\Http\Request;

class CarrierController extends Controller
{
    // Menampilkan daftar carrier
    public function index()
    {
        $carriers = Carrier::latest()->paginate(10);

        return view('carriers.index', compact('carriers'));
    }

    // Menampilkan form tambah carrier
    public function create()
    {
        return view('carriers.create');
    }


    // Menampilkan form edit carrier
    public function edit(Carrier $carrier)
    {
        return view('carriers.edit', compact('carrier'));
    }

    // Memperbarui data carrier
    public function update(Request $request, Carrier $carrier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:carriers,code,' . $carrier->id,
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $carrier->update([
            'name' => $request->name,
            'code' => $request->code,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()
            ->route('carriers.index')
            ->with('success', 'Data carrier berhasil diperbarui.');
    }


    // Menghapus data carrier
    public function destroy(Carrier $carrier)
    {
        $carrier->delete();

        return redirect()
            ->route('carriers.index')
            ->with('success', 'Data carrier berhasil dihapus.');
    }



    // Menyimpan data carrier
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:carriers,code',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        Carrier::create([
            'name' => $request->name,
            'code' => $request->code,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()
            ->route('carriers.index')
            ->with('success', 'Data carrier berhasil ditambahkan.');
    }
}
