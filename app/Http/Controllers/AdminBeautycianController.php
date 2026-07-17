<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminBeautycianController extends Controller
{
    public function index(Request $request)
    {
        $beautician = Karyawan::with('user')->orderBy('id_karyawan', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $beautician->where(function ($q) use ($search) {
                $q->where('jabatan', 'like', "%{$search}%")
                  ->orWhere('NIP', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('nama', 'like', "%{$search}%")
                         ->orWhere('role', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('filter_status')) {
            $beautician->where('status', $request->filter_status);
        }

        $beautician = $beautician->get();

        if ($request->ajax()) {
            return view('admin.beautician.partials.grid', compact('beautician'));
        }

        return view('admin.beautician.index', compact('beautician'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('karyawan')->get();
        return view('admin.beautician.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user'   => 'required|integer|exists:users,id',
            'NIP'       => 'required|string|max:255',
            'jabatan'   => 'required|string|max:50',
            'alamat'    => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'gaji'      => 'required|numeric',
            'komisi'    => 'required|numeric',
            'tgl_masuk' => 'required|date',
            'status'    => 'required|integer',
        ]);

        Karyawan::create($request->all());

        return redirect()->route('admin.beautician.index')
            ->with('success', 'Beautician berhasil ditambahkan.');
    }

    public function edit(Karyawan $beautician)
    {
        $beautician->load('user');
        $users = User::all();
        return view('admin.beautician.edit', compact('beautician', 'users'));
    }

    public function update(Request $request, Karyawan $beautician)
    {
        $request->validate([
            'id_user'   => 'required|integer|exists:users,id',
            'NIP'       => 'required|string|max:255',
            'jabatan'   => 'required|string|max:50',
            'alamat'    => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'gaji'      => 'required|numeric',
            'komisi'    => 'required|numeric',
            'tgl_masuk' => 'required|date',
            'status'    => 'required|integer',
        ]);

        $beautician->update($request->all());

        return redirect()->route('admin.beautician.index')
            ->with('success', 'Beautician berhasil diperbarui.');
    }

    public function destroy(Karyawan $beautician)
    {
        $user = $beautician->user;
        $beautician->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.beautician.index')
            ->with('success', 'Beautician berhasil dihapus.');
    }
}
