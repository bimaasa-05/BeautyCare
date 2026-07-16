<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $users->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }

        if ($request->filled('filter_role')) {
            $users->where('role', $request->filter_role);
        }

        if ($request->filled('filter_status')) {
            $users->where('status', $request->filter_status);
        }

        $users = $users->get();

        if ($request->ajax()) {
            return view('admin.user.partials.table', compact('users'));
        }

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'no_hp'    => 'nullable|string|max:20',
            'role'     => 'required|in:admin,kasir,beautycian,pelanggan',
            'status'   => 'required|in:aktif,non_aktif',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama', 'email', 'no_hp', 'role', 'status']);
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('users', 'public');
        }

        User::create($data);

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'no_hp'    => 'nullable|string|max:20',
            'role'     => 'required|in:admin,kasir,beautycian,pelanggan',
            'status'   => 'required|in:aktif,non_aktif',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama', 'email', 'no_hp', 'role', 'status']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('users', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->delete();

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
