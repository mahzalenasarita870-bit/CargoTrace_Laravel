<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'ADMIN') {
            abort(403, 'Akses hanya untuk Admin.');
        }

        $users = User::latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        if (auth()->user()->role !== 'ADMIN') {
            abort(403, 'Akses hanya untuk Admin.');
        }

        if ($user->id === auth()->id()) {
            return back()->with(
                'error',
                'Role akun yang sedang digunakan tidak dapat diubah.'
            );
        }

        $validated = $request->validate([
            'role' => 'required|in:ADMIN,OPERATOR,CUSTOMER',
        ]);

        $user->update([
            'role' => $validated['role'],
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'Role pengguna berhasil diperbarui.');
    }
}