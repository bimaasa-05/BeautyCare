<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminBeautycianController extends Controller
{
    public function index(Request $request)
    {
        $beautician = Karyawan::with('user')
            ->whereHas('user', fn ($q) => $q->whereIn('role', ['kasir', 'beautycian']))
            ->orderBy('id_karyawan', 'desc');

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

        $sibukIds = Booking::whereDate('tanggal', now()->toDateString())
            ->where('status', 'diproses')
            ->pluck('id_karyawan')
            ->unique();

        if ($request->filled('filter_status')) {
            $status = $request->filter_status;
            $beautician->whereHas('user', fn ($q) => $q->where('role', 'beautycian'));
            if ($status === 'Sibuk') {
                $beautician->whereIn('id_user', $sibukIds);
            } elseif ($status === 'Tersedia') {
                $beautician->where('status', '!=', 'Libur')
                    ->whereNotIn('id_user', $sibukIds);
            } else {
                $beautician->where('status', $status);
            }
        }

        $beautician = $beautician->get();

        if ($request->ajax()) {
            return view('admin.karyawan.partials.grid', compact('beautician', 'sibukIds'));
        }

        return view('admin.karyawan.index', compact('beautician', 'sibukIds'));
    }

    public function create()
    {
        $users = User::whereIn('role', ['kasir', 'beautycian'])->whereDoesntHave('karyawan')->get();
        return view('admin.karyawan.create', compact('users'));
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
            'status'    => 'required|string|in:Tersedia,Libur,Sibuk',
        ]);

        Karyawan::create($request->all());

        buatNotif(auth()->id(), 'Karyawan Ditambahkan', 'Karyawan NIP ' . $request->NIP . ' berhasil ditambahkan', 'Lainnya', route('admin.karyawan.index'));

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function show(Karyawan $beautician)
    {
        $beautician->load('user');
        $sibukIds = Booking::whereDate('tanggal', now()->toDateString())
            ->where('status', 'diproses')
            ->pluck('id_karyawan')
            ->unique();
        return view('admin.karyawan.show', compact('beautician', 'sibukIds'));
    }

    public function edit(Karyawan $beautician)
    {
        $beautician->load('user');
        $users = User::all();
        return view('admin.karyawan.edit', compact('beautician', 'users'));
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
            'status'    => 'required|string|in:Tersedia,Libur,Sibuk',
        ]);

        $beautician->update($request->all());

        buatNotif(auth()->id(), 'Karyawan Diperbarui', 'Karyawan ' . ($beautician->user->nama ?? '') . ' berhasil diperbarui', 'Lainnya', route('admin.karyawan.index'));

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $beautician)
    {
        $user = $beautician->user;
        $beautician->delete();
        if ($user) {
            $user->delete();
        }

        buatNotif(auth()->id(), 'Karyawan Dihapus', 'Karyawan berhasil dihapus dari sistem', 'Lainnya', route('admin.karyawan.index'));

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}
