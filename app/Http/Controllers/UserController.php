<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses hanya untuk Admin.');
        }

        $search = trim((string) $request->input('search', ''));
        $role = strtolower(trim((string) $request->input('role', '')));

        $users = User::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when(in_array($role, ['admin', 'operator', 'customer'], true), function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users', 'search', 'role'));
    }

    public function updateRole(Request $request, User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses hanya untuk Admin.');
        }

        if ($user->id === auth()->id()) {
            return back()->with(
                'error',
                'Role akun yang sedang digunakan tidak dapat diubah.'
            );
        }

        $validated = $request->validate([
            'role' => 'required|in:admin,operator,customer',
        ]);

        $user->update([
            'role' => $validated['role'],
        ]);

        return redirect()
            ->route('users.index', $request->only(['search', 'role', 'page']))
            ->with('success', 'Role pengguna berhasil diperbarui.');
    }
}